<?=$renderer->render('header')?>

<h1>Bienvenu Sur Le Blog</h1>
<ul></ul>
    <li><a href="<?=$router->generateUri('blog.show', ['slug' => 'ouiouimonsieur7']);?>">Los Article Uno</a></li>
    <li>Article</li>
    <li>Article</li>
    <li>Article</li>
</ul>

<?=$renderer->render('footer')?>
