<?php

include('amoCrm.php');
$note =  <<<END
1) Лимит получения через api сущностей;
2) Обработка события при устаревании refresh токена;
<strike>3) Вопрос об взаимодейтсвии БД и AmoCrm;</strike>
4) Реализация разновидностей note;
<strike>5) Создать функцию curl отправки запросов;</strike>
6) Обработка ошибок;
<strike>7)Пора подключать GIT; ++++++</strike>
<strike>8) Проверить создание задач, время создания некорректное;</strike>
<strike>9) Перевести curl-запросы в api.php на this->curl();</strike>
<strike>10) Отступы в коде;</strike>
11) Комментарии в коде;
END;
Aprint_r($note);

$str = <<<END
   ______
  / ____/___  ____ ___  ____  ____  ________  _____
 / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
/ /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
\____/\____/_/ /_/ /_/\____/\____/____/\___/_/


END;

Aprint_r($str);
