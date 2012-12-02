
<? /*
<?= Helper::exe('Main', 'Menu', array('awd')); ?>
<?= Helper::exe('Logger', 'index'); ?>
*/?>
<div class="row">
  <div class="hero-unit span5">
    <h1>Rubinchik Ilya - CV</h1>
  </div>
  <div class="span3">
    <a href="http://ilfate.net">http://ilfate.net</a><br>
    ilfate@gmail.com<br>
    Skype: illidanfate<br>
    Phone: +7 (905) 713-67-48<br>
  <a href="<?= HTTP_ROOT ?>Rubinchik_Ilya.pdf">Download CV</a>
  </div>
</div>

<div class="row">
  <div class="span4">
    <div>
      <h1>Languages</h1>
      Russian (fluent)<br>
      English (upper-intermediate)
    </div>
    <div>
      <h1>Education</h1>
      Moscow Aircraft Institute (2005-2011)<br>
      Rocket-science engineer (specialty: nano satellites)
    </div>
    <div>
      <h1 class="pull-left">Skills</h1> 
      <strong><a class="pull-left like-h1" href="<?=Helper::url('Cv', 'skills')?>">learn more</a></strong>
      <div class="clearfix"></div>
      Languages: PHP, JavaScript, Java<br>
      Web development: CSS, HTML/XHTML, Jquery, Bootstrap<br>
      DB: MySql <span class="tip" rel="tooltip" title="Module for MySql to work with it like noSql database" >HandlerSocket</span> Sphinx, Oracle, Redis<br>
      VCS: Svn, Git<br>
      Other: Nginx, Memcached, PHPUnit, Behat, Selenium, Phing<br>
      <a href="<?=Helper::url('Cv', 'skills')?>">My skills table</a>
    </div>
    <div>
      <h1>Certificates</h1> 
      <a target="_blank" class="pull-left cv-certificate"  href="http://www.zend.com/en/store/education/certification/yellow-pages.php#show-ClientCandidateID=ZEND021010">
        <img src="http://www.zend.com/img/yellowpages/zce_php5-3_logo.gif" />
      </a>
      <h4>PHP 5.3 Zend Certified Engineer</h4>
      Certification date: Oct 22nd, 2012<br>
      Zend Certificate page: 
      <a target="_blank" href="http://www.zend.com/en/store/education/certification/yellow-pages.php#show-ClientCandidateID=ZEND021010">
        Ilya Rubinchik
      </a>
    </div>
    <div>
      <h1>Interests</h1> 
      Web development<br>
      Game development<br>
      Snowboarding<br>
      Reading<br>
      Traveling<br>
      Bicycling<br>
    </div>
    <div>
      <h1>My social networks pages</h1> 
      <a target="_blank" href="http://vk.com/ilfate">Vkontakte</a><br>
      <a target="_blank" href="http://www.facebook.com/profile.php?id=100001037561585">Facebook</a><br>
      <a target="_blank" href="http://www.linkedin.com/pub/ilya-rubinchik/57/777/6b/en">LinkedIn</a><br>
      <a target="_blank" href="https://github.com/ilfate">Github</a><br>
      <a target="_blank" href="https://plus.google.com/u/0/104220186237319355155/posts">Google+</a><br>
    </div>
  </div>
  <div class="span4">
    <div>
      <h1>Work experience</h1>
      <h3>PHP Developer</h3>
        <a target="_blank" href="http://www.professionali.ru">Professionali.ru</a> - a huge Russian professional network<br>
        August 2012 - present. Moscow<br>
        I`m developing high load back-end. Responsible for network`s API and refactoring parts of core.<br>
        <span class="text-info">PHP + Mysql + Nginx</span>
      <h3>Leading Developer</h3>
        <a target="_blank" href="http://www.ddestiny.ru">Destiny Devopment</a> - GameDev company that specialize on Browser games<br> 
        Septeber 2011 - August 2012. Moscow<br>
        Leading developer on a browser game.<br>
        <span class="text-info">PHP + Mysql + Nginx</span>
      <h3>Leading Specialist (PHP)</h3>
        <a target="_blank" href="http://www.prognoz.ru">PROGNOZ</a> - Huge company that fills orders for government and banking<br>
        August 2010 - September 2011. Moscow<br>
        Creating and supporting ERP-like systems for Ministry of Health.<br>
        <span class="text-info">PHP + Oracle + IIS</span>
      <h3>PHP Developer</h3>
        M7 Software - a little company based on creating internet-shops and personal websites for clients<br>
        January 2009 - May 2010.(not full time job) Moscow<br>
        Creating sites based on company framework<br>
        <span class="text-info">PHP + MySql + Apache</span>
    </div>
    <div>
      <h1>Personal Projects</h1>
      <h3>Robot Rock</h3>
        Novemder 2010 - June 2011.<br>
        My first Php + Canvas game. Main purpose was to learn Canvas and increase my PHP skills<br>
        You can find animation demo and information at the link below <a href="<?=Helper::url('RobotRock')?>" >http://ilfate.net/RobotRock</a>
      <h3>Ilfate framework</h3>
        October 2012 - present.<br>
        My PHP micro-framework. ilfate.net is created using this framework<br>
        Github project: <a target="_blank" href="https://github.com/ilfate/ilfate_php_engine" >http://github.com/ilfate/ilfate_php_engine</a>
    </div>
  </div>
</div>



