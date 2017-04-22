## Useful links and notes

**FOSUserBundle**

* [CodeReviews](https://codereviewvideos.com/course/getting-started-with-fosuserbundle/video/fosuserbundle-and-bootstrap-3-template-customisation) 
(guide how to style templates and probably many more)


**Passing variables to twig paths**<br/>
[stack](http://stackoverflow.com/questions/31215134/how-to-pass-variable-from-twig-path-to-the-same-controller)
<br/>`{{ path('path', {'variable1': 'value1'} ) }}`

**Session variables in twig**<br/>
[stack](http://stackoverflow.com/questions/8399389/accessing-session-from-twig-template)

**Routing and redirecting**
[stack](http://stackoverflow.com/questions/11552718/is-it-possible-to-reload-a-page-in-symfony2-with-the-get-parameters-intact)
```php
 /**
 * @Route("/example-route")
exampleAction($data){
    $_SESSION['data'][] = $data; //adds data variable to session data array
    return $this->redirect($this->generateUrl('homepage')); // redirects back to homepage
}
```