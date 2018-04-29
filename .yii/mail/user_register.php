<?php

?>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
			<table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
						
						<table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Вы зарегистрированы на сайте <?= \Yii::$app->params['siteName'] ?></td></tr></tbody></table>
						<div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
							<b style="color: #777777;">Для входа используйте следующие данные:</b>
							<br>
							Адрес сайта: <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/" target="_blank"><?= $_SERVER['HTTP_HOST'] ?></a><br>
							E-mail: <?= $user->email ?><br>
							Пароль: <?= $password ?><br>
							<?php if($user->activeTill){ ?>
								Доступ открыт до <?= $user->activeTill ?><br>
							<?php } ?>
						</div>
						<br>
					</td></tr></tbody></table>
		</td></tr></tbody></table>



