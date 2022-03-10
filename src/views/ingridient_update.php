<?php
echo '<form method="POST" action="/ingridients/update/action">';
echo '<input type="hidden" name="id" value="'. $data->getId() .'">';
echo '<input name="name" value="'. $data->getName() .'">';
echo '<input name="description" value="'. $data->getDescription() .'">';
echo '<button>Правка</button>';
echo '</form>';