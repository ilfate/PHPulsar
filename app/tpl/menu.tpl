<div class="navbar navbar-fixed-top">
  <div class="">
    <div class="container">
      <a class="brand" href="#">Ilfate</a>
      <ul class="nav">
        <li class="active"><a href="#!/">Start</a></li>
        <li><a href="#!/success">Success</a></li>
        <li><a href="#!/error">Error</a></li>
      </ul>
      <? if(Service_Auth::isAuth()) { ?>
        <a > Logged as <?= Service_Auth::getUser()->name ?> </a>
      <? } else { ?>
        <div class="btn-group pull-right">
          <a href="#myModal" role="button" data-toggle="modal" class="btn btn-primary">Log in</a>
          <button class="btn btn-success">Sign up</button>
        </div>
     
        
      <? } ?>
    </div>
  </div>
</div>

<!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-off"></i></button>
        <h3 id="myModalLabel">Modal header</h3>
        </div>
        <div class="modal-body">
        <p>One fine body…</p>
        </div>
        <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save changes</button>
        </div>
        </div>