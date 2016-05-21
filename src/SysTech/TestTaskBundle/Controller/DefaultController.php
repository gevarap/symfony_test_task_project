<?php

namespace SysTech\TestTaskBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use SysTech\TestTaskBundle\Entity\commonDb\Mapping;
use SysTech\TestTaskBundle\Entity\commonDb\Repository\MappingRepository;
use SysTech\TestTaskBundle\Entity\commonDb\Repository\TableRelationsRepository;
use SysTech\TestTaskBundle\Entity\commonDb\TableRelations;

/**
 * Class DefaultController
 * @package SysTech\TestTaskBundle\Controller
 */
class DefaultController extends Controller {
  /**
   * @Route("/")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   * @Method({"GET", "POST"})
   */
  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager('commonDb');
    /** @var TableRelationsRepository $table_relations_repository */
    $table_relations_repository = $em->getRepository('BaseSynchronizeBundle:TableRelations');
    $tableRelations = $table_relations_repository->findAll();
    $form = $this->createFormBuilder()
      ->add('save', SubmitType::class, array('label' => 'Synchronize'))
      ->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var MappingRepository $mapping_repository */
        $mapping_repository = $em->getRepository('BaseSynchronizeBundle:Mapping');
        $mapping = $mapping_repository->findAllRelationKeyedIds();

        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($tableRelations as $relation) {
          /** @var TableRelations $relation */
          $relation_id = $relation->getId();
          $source_base = $relation->getSourceBase();
          $source_table = $relation->getSourceTable();
          $source_entity_name = $relation->getSourceEntity();
          /** @var ObjectManager[] $source_entity_managers */
          $source_entity_managers[$source_base] = $this->getDoctrine()->getManager($source_base);

          /** @var ObjectRepository[] $source_repositories */
          $source_repositories[$source_table] = $source_entity_managers[$source_base]->getRepository('BaseSynchronizeBundle:' . $source_entity_name);

          $source_corteges = $source_repositories[$source_table]->findAll();

          $target_base = $relation->getTargetBase();
          $target_table = $relation->getTargetTable();
          $target_entity_name = $relation->getTargetEntity();
          /** @var ObjectManager[] $target_entity_managers */
          $target_entity_managers[$target_base] = $this->getDoctrine()->getManager($target_base);

          /** @var ObjectRepository[] $target_repositories */
          $target_repositories[$target_table] = $target_entity_managers[$target_base]->getRepository('BaseSynchronizeBundle:' . $target_entity_name);
          $target_corteges = $target_repositories[$target_table]->findAll();

          $relation_first_db_synchronized_ids = array();
          $relation_second_db_synchronized_ids = array();
          /**
           * Can optimise this, but now I'm  not have time for this :(((((
           * @TODO: REFACTORING REFACTORING OWER everything
           */
          foreach ($source_corteges as $cortege) {
              if (!empty($mapping[$relation->getId()])) {
                /**
                 * If before this cortege was synchronized
                 */
                if (!empty($mapping[$relation->getId()]['db1_table_mapped_ids'][$accessor->getValue($cortege, 'id')])) {
                  $target_cortege_id = $mapping[$relation->getId()]['db1_table_mapped_ids'][$accessor->getValue($cortege, 'id')];
                  /**
                   * Check if this cortege exist yet in db_2
                   */
                  if (!empty($target_cortege = $target_repositories[$target_table]->findOneBy(array('id' => $target_cortege_id)))) {
                    $cortege_modify_at = $accessor->getValue($cortege, 'modifiedAt');
                    $cortege_id = $accessor->getValue($cortege, 'id');
                    $target_cortege_modify_at = $accessor->getValue($target_cortege, 'modifiedAt');
                    if ($cortege_modify_at > $target_cortege_modify_at) {
                      $mapping_updated = $mapping_repository->findOneBy(array(
                        'relationId' => $relation_id,
                        'firstId' => $cortege_id,
                      ));
                      $result = $this->synchronizeUpdate(array(
                        'cortege' => $cortege,
                        'entity_field' => $relation->getSourceField(),
                        'entity_manager_id' => $relation->getSourceBase(),
                      ), array(
                        'cortege' => $target_cortege,
                        'entity_manager' => $target_entity_managers[$relation->getTargetBase()],
                        'entity_name' => $relation->getTargetEntity(),
                        'entity_field' => $relation->getTargetField(),
                        'entity_manager_id' => $relation->getTargetBase(),
                      ), array(
                        'mapping_entity_manager' => $em,
                        'mapping' => $mapping_updated,
                      ));
                      $relation_first_db_synchronized_ids += $result['db1_table_synchronized_ids'];
                      $relation_second_db_synchronized_ids += $result['db2_table_synchronized_ids'];
                    }
                    elseif ($cortege_modify_at < $target_cortege_modify_at) {
                      $mapping_updated = $mapping_repository->findOneBy(array(
                        'relationId' => $relation_id,
                        'firstId' => $cortege_id,
                      ));
                      $result = $this->synchronizeUpdate(array(
                        'cortege' => $target_cortege,
                        'entity_field' => $relation->getTargetField(),
                        'entity_manager_id' => $relation->getTargetBase(),
                      ), array(
                        'cortege' => $cortege,
                        'entity_manager' => $source_entity_managers[$relation->getSourceBase()],
                        'entity_field' => $relation->getSourceField(),
                        'entity_manager_id' => $relation->getSourceBase(),
                        'entity_name' => $relation->getSourceEntity(),
                      ), array(
                        'mapping_entity_manager' => $em,
                        'mapping' => $mapping_updated,
                      ));
                      $relation_first_db_synchronized_ids += $result['db1_table_synchronized_ids'];
                      $relation_second_db_synchronized_ids += $result['db2_table_synchronized_ids'];
                    }
                    else {
                      $relation_first_db_synchronized_ids[$cortege_id] = $cortege_modify_at;
                      $relation_second_db_synchronized_ids[$target_cortege_id] = $target_cortege_modify_at;
                    }
                  }
                  else {
                    $cortege_modify_at = $accessor->getValue($cortege, 'modifiedAt');
                    $cortege_id = $accessor->getValue($cortege, 'id');
                    /** @var Mapping $mapping */
                    $mapping_element = $mapping_repository->findOneBy(array(
                      'firstId' => $cortege_id,
                      'relationId' => $relation_id
                    ));
                    $mapping_last_update = $mapping_element->getLastChangedTime();
                    /**
                     * "this" synchronized cortege was deleted earlier then we modify it then we again add it to Db2
                     */
                    if ($mapping_last_update < $cortege_modify_at) {
                      $result = $this->synchronizeInsert(array(
                        'cortege' => $cortege,
                        'entity_field' => $relation->getSourceField(),
                        'entity_manager_id' => $relation->getSourceBase(),
                      ), array(
                        'entity_manager' => $target_entity_managers[$relation->getTargetBase()],
                        'entity_name' => $relation->getTargetEntity(),
                        'entity_field' => $relation->getTargetField(),
                        'entity_manager_id' => $relation->getTargetBase(),
                      ), array(
                        'mapping_entity_manager' => $em,
                        'relation' => $relation,
                      ));
                      $relation_first_db_synchronized_ids += $result['db1_table_synchronized_ids'];
                      $relation_second_db_synchronized_ids += $result['db2_table_synchronized_ids'];
                    }
                    /**
                     * Else delete from our base this cortege too
                     * Don't forgot delete from Mapping
                     */
                    else {
                      $mapping_for_delete = $mapping_repository->findOneBy(array(
                        'firstId' => $accessor->getValue($cortege, 'id'),
                        'relationId' => $relation_id,
                      ));
                      $this->synchronizeDelete(array(
                        'entity_manager' => $source_entity_managers[$source_base],
                        'cortege' => $cortege
                      ), array(
                        'mapping_entity_manager' => $em,
                        'mapping' => $mapping_for_delete
                      ));
                    }
                  }
                }
                else  {

                  $result = $this->synchronizeInsert(array(
                    'cortege' => $cortege,
                    'entity_field' => $relation->getSourceField(),
                    'entity_manager_id' => $relation->getSourceBase(),
                  ), array(
                    'entity_manager' => $target_entity_managers[$relation->getTargetBase()],
                    'entity_name' => $relation->getTargetEntity(),
                    'entity_field' => $relation->getTargetField(),
                    'entity_manager_id' => $relation->getTargetBase(),
                  ), array(
                    'mapping_entity_manager' => $em,
                    'relation' => $relation,
                  ));
                  $relation_first_db_synchronized_ids += $result['db1_table_synchronized_ids'];
                  $relation_second_db_synchronized_ids += $result['db2_table_synchronized_ids'];
                }
              }
              else {

                $result = $this->synchronizeInsert(array(
                  'cortege' => $cortege,
                  'entity_field' => $relation->getSourceField(),
                  'entity_manager_id' => $relation->getSourceBase(),
                ), array(
                  'entity_manager' => $target_entity_managers[$relation->getTargetBase()],
                  'entity_name' => $relation->getTargetEntity(),
                  'entity_field' => $relation->getTargetField(),
                  'entity_manager_id' => $relation->getTargetBase(),
                ), array(
                  'mapping_entity_manager' => $em,
                  'relation' => $relation,
                ));
                $relation_first_db_synchronized_ids += $result['db1_table_synchronized_ids'];
                $relation_second_db_synchronized_ids += $result['db2_table_synchronized_ids'];
              }
            }


          foreach ($target_corteges as $cortege) {
            if (!in_array($accessor->getValue($cortege, 'id'), array_keys($relation_second_db_synchronized_ids))) {
              $cortege_modify_at = $accessor->getValue($cortege, 'modifiedAt');
              $cortege_id = $accessor->getValue($cortege, 'id');
              /** @var Mapping $mapping */
              $mapping_element = $mapping_repository->findOneBy(array(
                'secondId' => $cortege_id,
                'relationId' => $relation_id
              ));
              if ($mapping_element && $mapping_element->getLastChangedTime() >= $cortege_modify_at) {
                $this->synchronizeDelete(array(
                  'entity_manager' => $target_entity_managers[$target_base],
                  'cortege' => $cortege
                ), array(
                  'mapping_entity_manager' => $em,
                  'mapping' => $mapping_element
                ));
              }
              else {
                $result = $this->synchronizeInsert(array(
                  'cortege' => $cortege,
                  'entity_field' => $relation->getTargetField(),
                  'entity_manager_id' => $relation->getTargetBase(),
                ), array(
                  'entity_manager' => $source_entity_managers[$relation->getSourceBase()],
                  'entity_name' => $relation->getSourceEntity(),
                  'entity_field' => $relation->getSourceField(),
                  'entity_manager_id' => $relation->getSourceBase(),
                ), array(
                  'mapping_entity_manager' => $em,
                  'relation' => $relation,
                ));
                $relation_first_db_synchronized_ids += $result['db1_table_synchronized_ids'];
                $relation_second_db_synchronized_ids += $result['db2_table_synchronized_ids'];
              }
            }
          }

          foreach ($mapping_repository->findAll() as $mapping_ex) {
            $mapping_first_id = $accessor->getValue($mapping_ex, 'firstId');
            $mapping_second_id = $accessor->getValue($mapping_ex, 'secondId');
            $mapping_relation_id = $accessor->getValue($accessor->getValue($mapping_ex, 'relationId'), 'id');
            if ($relation_id === $mapping_relation_id && (!in_array($mapping_first_id, array_keys($relation_first_db_synchronized_ids)) || !in_array($mapping_second_id, array_keys($relation_second_db_synchronized_ids))) ) {
              $em->remove($mapping_ex);
              $em->flush();
            }
          }
        }
      return $this->redirectToRoute('/synchronize/success');
    }



    return $this->render('BaseSynchronizeBundle:Default:index.html.twig', array(
      'tableRelations' => $tableRelations,
      'form' => $form->createView(),
    ));
  }

  /**
   * @Route("/success", name="/synchronize/success")
   */
  public function successAction() {
    return Response::create('Synchronized!!!');
  }


  /**
   * @param $from
   * @param $to
   * @param $params
   * @return array
   * @internal param TableRelations $relation
   */
  private function synchronizeInsert($from, $to, $params) {

    /** @var ObjectManager $to_entity_manager */
    $accessor = PropertyAccess::createPropertyAccessor();
    $to_entity_manager = $to['entity_manager'];
    /** @var ObjectManager $mapping_entity_manager */
    $mapping_entity_manager = $params['mapping_entity_manager'];
    /** @var TableRelations $relation */
    $relation = $params['relation'];
    $from_cortege = $from['cortege'];
    $from_field = $from['entity_field'];
    $from_entity_manager_id = $from['entity_manager_id'];
    $to_entity_manager_id = $to['entity_manager_id'];
    $to_entity = $to['entity_name'];
    $to_field = $to['entity_field'];
    $obj = $to_entity_manager->getMetadataFactory()->getMetadataFor('BaseSynchronizeBundle:' . $to_entity)->getName();
    $new_cortege = new $obj();

    $cortege_modify_at = $accessor->getValue($from_cortege, 'modifiedAt');
    $cortege_created_at = $accessor->getValue($from_cortege, 'createdAt');
    $cortege_id = $accessor->getValue($from_cortege, 'id');
    $accessor->setValue($new_cortege, 'modifiedAt', $cortege_modify_at);
    $accessor->setValue($new_cortege, 'createdAt', $cortege_created_at);
    $accessor->setValue($new_cortege, $to_field, $accessor->getValue($from_cortege, $from_field));

    $to_entity_manager->persist($new_cortege);
    $to_entity_manager->flush();

    $new_cortege_id = $accessor->getValue($new_cortege, 'id');
    $new_mapping = new Mapping();
    $new_mapping->setAction('insert');
    $new_mapping->setRelationId($relation);
    $new_mapping->setLastChangedTime(time());
    if ($from_entity_manager_id == 'db2') {
      $new_mapping->setFirstId($new_cortege_id);
      $new_mapping->setSecondId($cortege_id);
    }
    else {
      $new_mapping->setFirstId($cortege_id);
      $new_mapping->setSecondId($new_cortege_id);
    }
    $mapping_entity_manager->persist($new_mapping);
    $mapping_entity_manager->flush();
    return array(
      $to_entity_manager_id . '_table_synchronized_ids' => array(
        $new_cortege_id => $cortege_modify_at,
      ),
      $from_entity_manager_id . '_table_synchronized_ids' => array(
        $cortege_id => $cortege_modify_at,
      ),
    );
  }

  /**
   * @param $from
   * @param $to
   * @param $params
   * @return array
   */
  private function synchronizeUpdate($from, $to, $params) {
    $accessor = PropertyAccess::createPropertyAccessor();
    /** @var Mapping $mapping */
    $mapping = $params['mapping'];
    /** @var ObjectManager $mapping_entity_manager */
    $mapping_entity_manager = $params['mapping_entity_manager'];
    $from_cortege = $from['cortege'];
    $from_field = $from['entity_field'];
    /** @var ObjectManager $to_entity_manager */
    $to_entity_manager = $to['entity_manager'];
    $to_cortege = $to['cortege'];
    $to_entity_manager_id = $to['entity_manager_id'];
    $from_entity_manager_id = $from['entity_manager_id'];
    $to_field = $to['entity_field'];
    $cortege_modify_at = $accessor->getValue($from_cortege, 'modifiedAt');
    $accessor->setValue($to_cortege, $to_field, $accessor->getValue($from_cortege, $from_field));
    $accessor->setValue($to_cortege, 'modified_at', $cortege_modify_at);
    $to_entity_manager->persist($to_cortege);
    $to_entity_manager->flush();


    $mapping->setAction('update');
    $mapping->setLastChangedTime(time());
    $mapping_entity_manager->persist($mapping);
    $mapping_entity_manager->flush();

    return array(
      $to_entity_manager_id . '_table_synchronized_ids' => array(
        $accessor->getValue($to_cortege, 'id') => $cortege_modify_at,
      ),
      $from_entity_manager_id . '_table_synchronized_ids' => array(
        $accessor->getValue($from_cortege, 'id') => $cortege_modify_at,
      ),
    );
  }

  /**
   * @param $from
   * @param $params
   */
  private function synchronizeDelete($from, $params) {

    /** @var ObjectManager $mapping_entity_manager */
    $mapping_entity_manager = $params['mapping_entity_manager'];
    $mapping_for_delete = $params['mapping'];
    $from_cortege = $from['cortege'];
    /** @var ObjectManager $from_entity_manager */
    $from_entity_manager = $from['entity_manager'];
    /**
     * @HACK  for `cleverest` database SQLite
     */
    /** @var EntityManager $from_entity_manager */
    if ($from_entity_manager->getConnection()->getParams()['driver'] === 'pdo_sqlite') {
      $from_entity_manager->getConnection()->fetchAssoc("PRAGMA foreign_keys = ON");
    }
    $from_entity_manager->remove($from_cortege);
    $from_entity_manager->flush();
    if ($mapping_for_delete) {
      $mapping_entity_manager->remove($mapping_for_delete);
      $mapping_entity_manager->flush();
    }

  }

}