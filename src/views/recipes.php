<table cellspacing="0">
    <h1>Рецепты</h1>
    <thead>
        <tr>
        </tr>
    </thead>
    <tbody>
            <tr>
                <?php foreach($data as $item) {
                    echo '<tr class="recipe_header">';
                    echo '<td class="recipes_names"><h3>'. $item->getName() .'</h3></td>';
                    echo '<td class="recipes_descriptions"></td>';
                    echo '<td></td>';
                    echo '</tr>';
                    echo '<tr class="recipe_ingridients">';
                    echo '<td valign="top"><strong>Описание:</strong><hr>' . $item->getDescription() . '</td>';
                    echo '<td valign="top"><strong>Ингридиенты:</strong><hr>';
                    foreach ($item->getIngridients() as $itemIngridient){
                        echo $itemIngridient['name'];
                        echo '<br>';
                    };
                    echo '</td>';
                    echo '<td valign="top"><strong>Приготовление:</strong><hr>' . $item->getMaking() . '</td>';
                    echo '</tr>';
                    if (!empty($item->getComments())){
                        echo '<td><strong>Комментарии:</strong></td><td>';
                        foreach ($item->getComments() as $itemComments){
                            echo '<p>'. $itemComments['comment'] .'</p>';
                        };
                        echo '</td><td></td>';
                    }
                    if ($userData['userlogin'] != null){
                        echo '</tr><td><strong>Ваш комментарий:</strong></td>';
                        echo '<td><form method="post" action="/recipes/comment/add">';
                        echo '<textarea name="comment_text" placeholder="'. $userData['userlogin'] .' пишет" ></textarea>';
                        echo '<input type="hidden" name="userid" value="'. $userData['userid'] .'">';
                        echo '<input type="hidden" name="recipeid" value="'. $item->getId() .'">';
                        echo '<p><button type="submit">Отправить</button></p></form></td>';
                        echo '<td></td>';
                    }
                }
                ?>
            </tr>
    </tbody>
</table>