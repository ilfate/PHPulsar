

<div class="row">
  <div class="span8 offset1">
    <h1>Robot Rock animation demo fight</h1>
    <div id="div_canvas">
    </div>
    
    
  </div>
</div>

		
<script >
  
  var map = [[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,2,2,2,2,2,1,2,2,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0],[0,2,2,1,2,2,2,2,2,2,2,0,0,0,0,0,0,0,0,0],[0,2,0,0,2,2,2,2,2,2,2,0,0,0,0,0,0,0,0,0],[0,2,0,0,2,2,2,2,2,2,2,2,2,2,0,0,0,0,0,0],[2,2,2,1,2,2,2,1,1,1,0,0,0,2,0,0,0,0,0,0],[0,1,2,1,1,2,2,1,2,2,2,0,0,2,0,0,0,0,0,0],[0,2,2,1,2,1,2,1,2,2,2,2,2,2,0,0,0,0,0,0],[0,1,0,1,2,1,2,1,2,2,2,2,0,2,0,0,0,0,0,0],[0,2,2,2,2,2,2,1,2,1,2,2,2,2,0,0,0,0,0,0],[0,2,0,2,2,1,1,1,2,2,2,2,1,2,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],];
console.info(map);
game = new RRAnimator(map);
game.init("<?=HTTP_ROOT.'rr/'?>");
pl = []; 

pl[3] = new Player();
var pl_t = pl[3];
pl_t.id = 3;
pl_t.events = [{"code":"F1","time":4091,"attrs":{"start_time":4091,"start_x":5.5,"start_y":8.5,"end_time":4271,"end_x":7.37,"end_y":11.39}}];
pl_t.bot.id = 3;
pl_t.bot.x = 14;
pl_t.bot.y = 14;
pl_t.bot.d = 1;
pl_t.bot.model = Math.round(Math.random()*2+1);
//pl_t.bot.marg = 16;
pl_t.log = {11:"M1",261:"M1",511:"M1",761:"M1",1011:"M1",1261:"M1",1511:"R2",1671:"M1",1921:"M1",2171:"M1",2421:"M1",2671:"M1",2921:"M1",3171:"M1",3421:"M1",3671:"M1",3921:"R2",4091:"F1",4591:"D1",5551:"ST"};
//console.log({11:"M1",261:"M1",511:"M1",761:"M1",1011:"M1",1261:"M1",1511:"R2",1671:"M1",1921:"M1",2171:"M1",2421:"M1",2671:"M1",2921:"M1",3171:"M1",3421:"M1",3671:"M1",3921:"R2",4091:"F1",4591:"D1",5551:"ST"});
game.addPlayer(pl_t); 

//console.info([{"code":"F1","time":3001,"attrs":{"start_time":3001,"start_x":6.5,"start_y":5.5,"end_time":3241,"end_x":9.62,"end_y":9.1}},{"code":"F1","time":3501,"attrs":{"start_time":3501,"start_x":6.5,"start_y":5.5,"end_time":3821,"end_x":7.74,"end_y":11.39}},{"code":"F1","time":4001,"attrs":{"start_time":4001,"start_x":6.5,"start_y":5.5,"end_time":4161,"end_x":5.45,"end_y":8.35}},{"code":"F1","time":4501,"attrs":{"start_time":4501,"start_x":6.5,"start_y":5.5,"end_time":4721,"end_x":4.96,"end_y":9.68}},{"code":"F1","time":5341,"attrs":{"start_time":5341,"start_x":6.5,"start_y":6.5,"end_time":5501,"end_x":7.4,"end_y":9.35}}]);
pl[1] = new Player();
var pl_t = pl[1];
pl_t.id = 1;
pl_t.events = [{"code":"F1","time":3001,"attrs":{"start_time":3001,"start_x":6.5,"start_y":5.5,"end_time":3241,"end_x":9.62,"end_y":9.1}},{"code":"F1","time":3501,"attrs":{"start_time":3501,"start_x":6.5,"start_y":5.5,"end_time":3821,"end_x":7.74,"end_y":11.39}},{"code":"F1","time":4001,"attrs":{"start_time":4001,"start_x":6.5,"start_y":5.5,"end_time":4161,"end_x":5.45,"end_y":8.35}},{"code":"F1","time":4501,"attrs":{"start_time":4501,"start_x":6.5,"start_y":5.5,"end_time":4721,"end_x":4.96,"end_y":9.68}},{"code":"F1","time":5341,"attrs":{"start_time":5341,"start_x":6.5,"start_y":6.5,"end_time":5501,"end_x":7.4,"end_y":9.35}}];
pl_t.bot.id = 1;
pl_t.bot.x = 2;
pl_t.bot.y = 2;
pl_t.bot.d = 3;
pl_t.bot.model = Math.round(Math.random()*2+1);
//pl_t.bot.marg = 16;
pl_t.log = {11:"R2",171:"M1",511:"M1",841:"M1",1171:"M1",1511:"R2",1671:"R2",1841:"R2",2001:"M1",2341:"M1",2671:"M1",3001:"F1",3501:"F1",4001:"F1",4501:"F1",5001:"M1",5341:"F1",5551:"ST"};
//console.log({11:"R2",171:"M1",511:"M1",841:"M1",1171:"M1",1511:"R2",1671:"R2",1841:"R2",2001:"M1",2341:"M1",2671:"M1",3001:"F1",3501:"F1",4001:"F1",4501:"F1",5001:"M1",5341:"F1",5551:"ST"});
game.addPlayer(pl_t); 

//console.info([{"code":"F1","time":3371,"attrs":{"start_time":3371,"start_x":7.5,"start_y":11.5,"end_time":3651,"end_x":7.78,"end_y":5.9}},{"code":"F1","time":3871,"attrs":{"start_time":3871,"start_x":7.5,"start_y":11.5,"end_time":4061,"end_x":5.7,"end_y":8.44}},{"code":"F1","time":4371,"attrs":{"start_time":4371,"start_x":7.5,"start_y":11.5,"end_time":4551,"end_x":5.63,"end_y":8.61}}]);
pl[2] = new Player();
var pl_t = pl[2];
pl_t.id = 2;
pl_t.events = [{"code":"F1","time":3371,"attrs":{"start_time":3371,"start_x":7.5,"start_y":11.5,"end_time":3651,"end_x":7.78,"end_y":5.9}},{"code":"F1","time":3871,"attrs":{"start_time":3871,"start_x":7.5,"start_y":11.5,"end_time":4061,"end_x":5.7,"end_y":8.44}},{"code":"F1","time":4371,"attrs":{"start_time":4371,"start_x":7.5,"start_y":11.5,"end_time":4551,"end_x":5.63,"end_y":8.61}}];
pl_t.bot.id = 2;
pl_t.bot.x = 2;
pl_t.bot.y = 14;
pl_t.bot.d = 1;
pl_t.bot.model = Math.round(Math.random()*2+1);
//pl_t.bot.marg = 16;
pl_t.log = {41:"M1",381:"R2",541:"R2",711:"R2",871:"M1",1211:"M1",1541:"M1",1871:"M1",2211:"M1",2541:"R2",2711:"M1",3041:"M1",3371:"F1",3871:"F1",4371:"F1",4871:"M1",5201:"M1",5541:"D1",5551:"ST"};
//console.log({41:"M1",381:"R2",541:"R2",711:"R2",871:"M1",1211:"M1",1541:"M1",1871:"M1",2211:"M1",2541:"R2",2711:"M1",3041:"M1",3371:"F1",3871:"F1",4371:"F1",4871:"M1",5201:"M1",5541:"D1",5551:"ST"});
game.addPlayer(pl_t); 

game.draw();

<?/*
  var map = [[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,2,2,2,2,2,1,2,2,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0],[0,2,2,1,2,2,2,2,2,2,2,0,0,0,0,0,0,0,0,0],[0,2,0,0,2,2,2,2,2,2,2,0,0,0,0,0,0,0,0,0],[0,2,0,0,2,2,2,2,2,2,2,2,2,2,0,0,0,0,0,0],[2,2,2,1,2,2,2,1,1,1,0,0,0,2,0,0,0,0,0,0],[0,1,2,1,1,2,2,1,2,2,2,0,0,2,0,0,0,0,0,0],[0,2,2,1,2,1,2,1,2,2,2,2,2,2,0,0,0,0,0,0],[0,1,0,1,2,1,2,1,2,2,2,2,0,2,0,0,0,0,0,0],[0,2,2,2,2,2,2,1,2,1,2,2,2,2,0,0,0,0,0,0],[0,2,0,2,2,1,1,1,2,2,2,2,1,2,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],];
  //console.info(map);
  game = new RRAnimator(map);
  game.init("<?=HTTP_ROOT.'rr/'?>");
  pl = []; 

  pl[3] = new Player();
  var pl_t = pl[3];
  pl_t.id = 3;
  pl_t.events = [{"code":"F1","time":4091,"attrs":{"start_time":4091,"start_x":5.5,"start_y":8.5,"end_time":4271,"end_x":7.37,"end_y":11.39}}];
  pl_t.bot.id = 3;
  pl_t.bot.x = 14;
  pl_t.bot.y = 14;
  pl_t.bot.d = 1;
  pl_t.bot.model = Math.round(Math.random()*2+1);
  //pl_t.bot.marg = 16;
  pl_t.log = {11:"M1",261:"M1",511:"M1",761:"M1",1011:"M1",1261:"M1",1511:"R2",1671:"M1",1921:"M1",2171:"M1",2421:"M1",2671:"M1",2921:"M1",3171:"M1",3421:"M1",3671:"M1",3921:"R2",4091:"F1",4591:"D1",5551:"ST"};
  //console.log({11:"M1",261:"M1",511:"M1",761:"M1",1011:"M1",1261:"M1",1511:"R2",1671:"M1",1921:"M1",2171:"M1",2421:"M1",2671:"M1",2921:"M1",3171:"M1",3421:"M1",3671:"M1",3921:"R2",4091:"F1",4591:"D1",5551:"ST"});
  game.addPlayer(pl_t); 

  //console.info([{"code":"F1","time":3001,"attrs":{"start_time":3001,"start_x":6.5,"start_y":5.5,"end_time":3241,"end_x":9.62,"end_y":9.1}},{"code":"F1","time":3501,"attrs":{"start_time":3501,"start_x":6.5,"start_y":5.5,"end_time":3821,"end_x":7.74,"end_y":11.39}},{"code":"F1","time":4001,"attrs":{"start_time":4001,"start_x":6.5,"start_y":5.5,"end_time":4161,"end_x":5.45,"end_y":8.35}},{"code":"F1","time":4501,"attrs":{"start_time":4501,"start_x":6.5,"start_y":5.5,"end_time":4721,"end_x":4.96,"end_y":9.68}},{"code":"F1","time":5341,"attrs":{"start_time":5341,"start_x":6.5,"start_y":6.5,"end_time":5501,"end_x":7.4,"end_y":9.35}}]);
  pl[1] = new Player();
  var pl_t = pl[1];
  pl_t.id = 1;
  pl_t.events = [{"code":"F1","time":3001,"attrs":{"start_time":3001,"start_x":6.5,"start_y":5.5,"end_time":3241,"end_x":9.62,"end_y":9.1}},{"code":"F1","time":3501,"attrs":{"start_time":3501,"start_x":6.5,"start_y":5.5,"end_time":3821,"end_x":7.74,"end_y":11.39}},{"code":"F1","time":4001,"attrs":{"start_time":4001,"start_x":6.5,"start_y":5.5,"end_time":4161,"end_x":5.45,"end_y":8.35}},{"code":"F1","time":4501,"attrs":{"start_time":4501,"start_x":6.5,"start_y":5.5,"end_time":4721,"end_x":4.96,"end_y":9.68}},{"code":"F1","time":5341,"attrs":{"start_time":5341,"start_x":6.5,"start_y":6.5,"end_time":5501,"end_x":7.4,"end_y":9.35}}];
  pl_t.bot.id = 1;
  pl_t.bot.x = 2;
  pl_t.bot.y = 2;
  pl_t.bot.d = 3;
  pl_t.bot.model = Math.round(Math.random()*2+1);
  //pl_t.bot.marg = 16;
  pl_t.log = {11:"R2",171:"M1",511:"M1",841:"M1",1171:"M1",1511:"R2",1671:"R2",1841:"R2",2001:"M1",2341:"M1",2671:"M1",3001:"F1",3501:"F1",4001:"F1",4501:"F1",5001:"M1",5341:"F1",5551:"ST"};
  //console.log({11:"R2",171:"M1",511:"M1",841:"M1",1171:"M1",1511:"R2",1671:"R2",1841:"R2",2001:"M1",2341:"M1",2671:"M1",3001:"F1",3501:"F1",4001:"F1",4501:"F1",5001:"M1",5341:"F1",5551:"ST"});
  game.addPlayer(pl_t); 

  //console.info([{"code":"F1","time":3371,"attrs":{"start_time":3371,"start_x":7.5,"start_y":11.5,"end_time":3651,"end_x":7.78,"end_y":5.9}},{"code":"F1","time":3871,"attrs":{"start_time":3871,"start_x":7.5,"start_y":11.5,"end_time":4061,"end_x":5.7,"end_y":8.44}},{"code":"F1","time":4371,"attrs":{"start_time":4371,"start_x":7.5,"start_y":11.5,"end_time":4551,"end_x":5.63,"end_y":8.61}}]);
  pl[2] = new Player();
  var pl_t = pl[2];
  pl_t.id = 2;
  pl_t.events = [{"code":"F1","time":3371,"attrs":{"start_time":3371,"start_x":7.5,"start_y":11.5,"end_time":3651,"end_x":7.78,"end_y":5.9}},{"code":"F1","time":3871,"attrs":{"start_time":3871,"start_x":7.5,"start_y":11.5,"end_time":4061,"end_x":5.7,"end_y":8.44}},{"code":"F1","time":4371,"attrs":{"start_time":4371,"start_x":7.5,"start_y":11.5,"end_time":4551,"end_x":5.63,"end_y":8.61}}];
  pl_t.bot.id = 2;
  pl_t.bot.x = 2;
  pl_t.bot.y = 14;
  pl_t.bot.d = 1;
  pl_t.bot.model = Math.round(Math.random()*2+1);
  //pl_t.bot.marg = 16;
  pl_t.log = {41:"M1",381:"R2",541:"R2",711:"R2",871:"M1",1211:"M1",1541:"M1",1871:"M1",2211:"M1",2541:"R2",2711:"M1",3041:"M1",3371:"F1",3871:"F1",4371:"F1",4871:"M1",5201:"M1",5541:"D1",5551:"ST"};
  //console.log({41:"M1",381:"R2",541:"R2",711:"R2",871:"M1",1211:"M1",1541:"M1",1871:"M1",2211:"M1",2541:"R2",2711:"M1",3041:"M1",3371:"F1",3871:"F1",4371:"F1",4871:"M1",5201:"M1",5541:"D1",5551:"ST"});
  game.addPlayer(pl_t); 

  game.draw();
  */?>
</script>