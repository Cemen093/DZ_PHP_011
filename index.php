<?php

//Создать класс Card (ФИО и логин + пароль)
//Дать возможность принять у пользователя через form данные
//Сделать страницу с таблицей всех пользователей (+ возможность удаления конкретного)
//Хранить всех в JSON файле

//хранить в json файле, ок. Но обязатьельно в формате json?? можно использовать serialize()?

class Card{
    private $name;
    private $surname;
    private $patronymic;
    private $login;
    private $password;

    /**
     * @param $name
     * @param $surname
     * @param $patronymic
     * @param $login
     * @param $password
     */
    public function __construct($name, $surname, $patronymic, $login, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}

$FILENAME = "data.json";
$users = unserialize(file_get_contents($FILENAME));
if (isset($_GET["add_user"])){
    //проверок нет
    $user = new Card($_GET["name"], $_GET["surname"], $_GET["patronymic"], $_GET["login"], $_GET["password"]);
    array_push($users, $user);
    file_put_contents($FILENAME, serialize($users));
}

if (isset($_GET['del_user'])){
    //при совпадении логинов удаляется первый попавшийся
    $login = $_GET["login"];
    print_r('</br>');
    foreach ($users as $index => $user){
        if ($user->getLogin() == $login){
            unset($users[$index]);
            break;
        }
    }
    file_put_contents($FILENAME, serialize($users));
}

$table = '';
foreach ($users as $user){
    $table .= '<div>name: '.$user->getName().'; surname: '.$user->getSurname().'; patronymic: '.$user->getPatronymic().'login: '.$user->getLogin().'; password: '.$user->getPassword().';</div>';
}

echo '
<div style="display: flex">
    <div>
        <form action="" method="GET">
        <input name="name" placeholder="name"/>
        </br>
        <input name="surname" placeholder="surname"/>
        </br>
        <input name="patronymic" placeholder="patronymic"/>
        </br>
        <input name="login" placeholder="login"/>
        </br>
        <input name="password" placeholder="password"/>
        </br>
        <input name="repeatPassword" placeholder="repeat password"/>
        </br>
        <button type="submit" name="add_user">Add user</button>
        </form>
    </div>
    <div>
        '.$table.'
    </div>
    <div>
        <form action="" method="GET">
            <input name="login" placeholder="login">
            </br>
            <button type="submit" name="del_user">Del user</button>
        </form>    
    </div>
</div>';

//$users = unserialize($_COOKIE['users']);
//array_push($users, new User($_GET["name"], $_GET["surname"], $_GET["patronymic"], $_GET["age"]));
//setcookie("users",serialize($users), time()+3600);
