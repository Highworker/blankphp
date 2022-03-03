<?php
echo '<form method="POST" action="/recipes/update/action">';
echo '<input type="hidden" name="id" value="'. $data->getId() .'">';
echo '<input name="name" value="'. $data->getName() .'">';
echo '<input name="description" value="'. $data->getDescription() .'">';
echo '<input name="making" value="'. $data->getMaking() .'">';
echo '<button>Правка</button>';
echo '</form>';