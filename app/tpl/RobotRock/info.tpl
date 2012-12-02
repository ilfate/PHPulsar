


To watch one more time <a class="btn" href="<?=Helper::url('RobotRock')?>">Restart</a>.<br>
<br>
<h3>Info</h3>
This is one of my oldest projects. Robot Rock was planned as a browser game for programmers. 
The idea was to create a game where any one could develop his own AI and fight with the others players.
Player was able to submit AI code, choose opponent and then just sit and watch his robot fighting.

<h3>How it works</h3>
Player was able to write code in Php, Js or Java! When fight started Php gameCore start generating fight log. 
It sent requests to code servers (php, js or java)
and received robot actions. When fight was over gameCore created game log in json format and sent it to player browser. 
So that way player saw game only after whole fight had been generated.<br>
Also to display this animation i created my own Canvas framework named PulsarCV.

<br>
<br>

<a class="btn" href="<?= Helper::url("Cv") ?>"> << Back to CV</a>