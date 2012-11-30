


To watch one more time <a class="btn" href="<?=Helper::url(array('RobotRock'))?>">Restart</a>.<br>
<br>
<h3>Info</h3>
This is one of my oldest projects. Robot Rock was planned as a browser game for programmers. 
The idea was to create a game where any one can develop his own AI and fight with the others players.
Player submits AI code, chooses opponent and then just sits and watches his robot fighting.

<h3>How it works</h3>
Player was able to write code in Php, Js or Java! When fight starts Php gameCore starts generating fight log. It sends requests to code servers (php, js or java)
and receives robot actions. When fight is over gameCore creates game log in json format and send it to player browser. 
So that way player sees game only after whole fight been generated.<br>
Also to display this animation i created my own Canvas framework named PulsarCV.


