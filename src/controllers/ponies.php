<?php

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


/*
|--------------------------------------------------------------------------
| Ponies
|--------------------------------------------------------------------------
|
|
 */


/**
 * Pony - Create
 */

$app->match('/pony/create', function(Request $request) use ($app) {

  if ($request->request->count()){
    $request->request->remove('singlebutton');

    $fur = $request->request->get('fur');
    $eyes = $request->request->get('eyes');

    $request->request->remove('fur');
    $request->request->remove('eyes');

    $data = $request->request->all();

    $app['db']->insert('ponies', $data);

    $app['session']->getFlashBag()->add('success', '<strong>SUCCESS!</strong> Record was successfully saved.');

    $id = $app['db']->lastInsertId();

    if ($id !== false && !is_null($id)){
      $app['db']->insert('pony_furs', array('pony_id' => (int) $id, 'fur_id' => (int)$fur));
      $app['db']->insert('pony_eyes', array('pony_id' => (int) $id, 'eye_id' => (int)$eyes));
      return $app->redirect('/pony/'.$id.'/edit');
    } else {
      return $app->redirect('/');
    }
  }

  /* Build out the fur color drop down */
  $furs = $app['db']->fetchAll('SELECT id, color name FROM furs ORDER BY id');
  
  /* Build out the eye color drop down */
  $eyes = $app['db']->fetchAll('SELECT id, color name FROM eyes ORDER BY id');

  $fields = array(
    'name' => array('title' => 'Name', 'type' => 'text'),
    'height' => array('title' => 'Height', 'type' => 'text'),
    'weight' => array('title' => 'Weight', 'type' => 'text'),
    'fur' => array('title' => 'Fur Color', 'type' => 'select', 'key' => 'id', 'data' => $furs),
    'eyes' => array('title' => 'Eye Color', 'type' => 'select', 'key' => 'id', 'data' => $eyes)
  );

  $row = array();

  foreach($fields as $key => $item){
    $row[$key] = '';
  }

  return $app['twig']->render('pony/create.html.twig', array(
    'form' => array(
      'name' => 'Add a new pony',
      'content' => $row,
      'fields' => $fields,
      'hide' => array(),
      'alerts' => array()
    )
  ));
});

/**
 * Pony - Edit
 */

$app->match('/pony/{id}/edit', function(Request $request, $id) use ($app) {

  if ($request->request->count()){
    $request->request->remove('singlebutton');
    $fur = $request->request->get('fur');
    $eyes = $request->request->get('eyes');

    $request->request->remove('fur');
    $request->request->remove('eyes');

    $app['db']->update('ponies', $request->request->all(), array('id' => (int) $id));
    $app['db']->update('pony_furs', array('fur_id'=>(int)$fur), array('pony_id' => (int) $id));
    $app['db']->update('pony_eyes', array('eye_id'=>(int)$eyes), array('pony_id' => (int) $id));

    $app['session']->getFlashBag()->add('success', '<strong>SUCCESS!</strong> Pony was successfully updated.');
  }

  /* Get the selected pony */
  $sql = "
SELECT p.id, p.name, p.height, p.weight, f.id fur, e.id eyes FROM ponies p
LEFT JOIN pony_eyes pe ON pe.pony_id = p.id
LEFT JOIN pony_furs pf ON pf.pony_id = p.id
LEFT JOIN eyes e ON e.id = pe.eye_id
LEFT JOIN furs f ON f.id = pf.fur_id
WHERE p.id = " . (int) $id;

  $row = $app['db']->fetchAssoc($sql, array());

  /* Build out the fur color drop down */
  $furs = $app['db']->fetchAll('SELECT id, color name FROM furs ORDER BY id');
  
  /* Build out the eye color drop down */
  $eyes = $app['db']->fetchAll('SELECT id, color name FROM eyes ORDER BY id');

  $fields = array(
    'name' => array('title' => 'Name', 'type' => 'text'),
    'height' => array('title' => 'Height', 'type' => 'text'),
    'weight' => array('title' => 'Weight', 'type' => 'text'),
    'fur' => array('title' => 'Fur Color', 'type' => 'select', 'key' => 'id', 'data' => $furs),
    'eyes' => array('title' => 'Eye Color', 'type' => 'select', 'key' => 'id', 'data' => $eyes)
  );

  $hide = array('id');

  return $app['twig']->render('pony/edit.html.twig', array(
    'form' => array(
      'name' => 'Edit ' . $row['name'],
      'content' => $row,
      'fields' => $fields,
      'hide' => $hide
    )
  ));
});


/**
 * Pony - Delete
 */

$app->match('/pony/{id}/delete', function(Request $request, $id) use ($app) {

  if ($request->request->count()){
    if ($request->request->get('action-delete') == 'delete'){
      $app['db']->delete('pony_furs', array('pony_id' => (int) $id));
      $app['db']->delete('pony_eyes', array('pony_id' => (int) $id));
      $app['db']->delete('pony_friends', array('pony_id' => (int) $id));
      $app['db']->delete('pony_friends', array('friend_id' => (int) $id));
      $app['db']->delete('ponies', array('id' => (int) $id));

      $app['session']->getFlashBag()->add('success', '<strong>SUCCESS!</strong> Pony was successfully deleted.');

      return $app->redirect('/');
    }
  }

  $sql = "SELECT * FROM ponies WHERE id = " . (int) $id;
  $row = $app['db']->fetchAssoc($sql, array());

  return $app['twig']->render('pony/delete.html.twig', array(
    'title' => $row['name'],
  ));
});