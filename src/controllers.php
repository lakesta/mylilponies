<?php

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

require_once ('controllers/ponies.php');

$app['twig']->addFilter(new Twig_SimpleFilter('blob', function($string) {
  return stream_get_contents($string);
}));


/*
    Home page that shows list of ponies
*/
$app->match('/', function() use ($app) {
  $list_header = array(
    'id',
    'name',
    'height',
    'weight',
    'fur',
    'eyes',
    'actions',
  );

  $list_actions = array(
    array(
      'title' => 'edit',
      'link' => '/pony/%id%/edit'
    ),
    array(
      'title' => 'delete',
      'link' => '/pony/%id%/delete'
    ),
  );

  $sql = "
SELECT p.id, p.name, p.height, p.weight, f.color fur, e.color eyes FROM ponies p
LEFT JOIN pony_eyes pe ON pe.pony_id = p.id
LEFT JOIN pony_furs pf ON pf.pony_id = p.id
LEFT JOIN eyes e ON e.id = pe.eye_id
LEFT JOIN furs f ON f.id = pf.fur_id;
    ";


  return $app['twig']->render('pony/view.html.twig', array(
    'list' => $app['db']->fetchAll($sql, array()),
    'list_hide' => array('id'),
    'list_header' => $list_header,
    'list_actions' => $list_actions
  ));
})->bind('ponies');

$app->match('/form', function(Request $request) use ($app) {

    $builder = $app['form.factory']->createBuilder('form');
    $choices = array('choice a', 'choice b', 'choice c');

    $form = $builder
        ->add(
            $builder->create('sub-form', 'form')
                ->add('subformemail1', 'email', array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Email()),
                    'attr'        => array('placeholder' => 'email constraints'),
                    'label'       => 'A custom label : ',
                ))
                ->add('subformtext1', 'text')
        )
        ->add('text1', 'text', array(
            'constraints' => new Assert\NotBlank(),
            'attr'        => array('placeholder' => 'not blank constraints')
        ))
        ->add('text2', 'text', array('attr' => array('class' => 'span1', 'placeholder' => '.span1')))
        ->add('text3', 'text', array('attr' => array('class' => 'span2', 'placeholder' => '.span2')))
        ->add('text4', 'text', array('attr' => array('class' => 'span3', 'placeholder' => '.span3')))
        ->add('text5', 'text', array('attr' => array('class' => 'span4', 'placeholder' => '.span4')))
        ->add('text6', 'text', array('attr' => array('class' => 'span5', 'placeholder' => '.span5')))
        ->add('text8', 'text', array('disabled' => true, 'attr' => array('placeholder' => 'disabled field')))
        ->add('textarea', 'textarea')
        ->add('email', 'email')
        ->add('integer', 'integer')
        ->add('money', 'money')
        ->add('number', 'number')
        ->add('password', 'password')
        ->add('percent', 'percent')
        ->add('search', 'search')
        ->add('url', 'url')
        ->add('choice1', 'choice',  array(
            'choices'  => $choices,
            'multiple' => true,
            'expanded' => true
        ))
        ->add('choice2', 'choice',  array(
            'choices'  => $choices,
            'multiple' => false,
            'expanded' => true
        ))
        ->add('choice3', 'choice',  array(
            'choices'  => $choices,
            'multiple' => true,
            'expanded' => false
        ))
        ->add('choice4', 'choice',  array(
            'choices'  => $choices,
            'multiple' => false,
            'expanded' => false
        ))
        ->add('country', 'country')
        ->add('language', 'language')
        ->add('locale', 'locale')
        ->add('timezone', 'timezone')
        ->add('date', 'date')
        ->add('datetime', 'datetime')
        ->add('time', 'time')
        ->add('birthday', 'birthday')
        ->add('checkbox', 'checkbox')
        ->add('file', 'file')
        ->add('radio', 'radio')
        ->add('password_repeated', 'repeated', array(
            'type'            => 'password',
            'invalid_message' => 'The password fields must match.',
            'options'         => array('required' => true),
            'first_options'   => array('label' => 'Password'),
            'second_options'  => array('label' => 'Repeat Password'),
        ))
        ->add('submit', 'submit')
        ->getForm()
    ;

    if ($request->isMethod('POST')) {
        if ($form->submit($request)->isValid()) {
            $app['session']->getFlashBag()->add('success', 'The form is valid');
        } else {
            $form->addError(new FormError('This is a global error'));
            $app['session']->getFlashBag()->add('info', 'The form is bind, but not valid');
        }
    }

    return $app['twig']->render('form.html.twig', array('form' => $form->createView()));
})->bind('form');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    var_dump($e);

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

return $app;
