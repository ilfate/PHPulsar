
<? /*
<?= Helper::exe('Main', 'Menu', array('awd')); ?>
<?= Helper::exe('Logger', 'index'); ?>
*/?>


<div id="start" class="block">
	<div class="userplace">
		<label for="username">Имя пользователя: </label>
		<input type="text" id="username" />
	</div>
	<div class="buttonplace">
		<input type="button" value="Проверить" />
	</div>
</div>
<div id="error" class="block">
    Ошибка такой пользователь не найден.
</div>
<div id="success" class="block">
    Пользователь найден.
</div>