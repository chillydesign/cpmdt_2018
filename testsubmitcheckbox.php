<?php

if ($_POST) :

    var_dump($_POST);
endif;

?>

<form method="POST" action="">
    <select multiple name="2test[]" id="other_places_container">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>

    <input type="checkbox" name="1test[]" value="1" />
    <input type="checkbox" name="1test[]" value="2" />
    <input type="checkbox" name="1test[]" value="3" />

    <button type="submit">Go</button>

</form>