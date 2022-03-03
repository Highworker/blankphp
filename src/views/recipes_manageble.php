<table>
    <h1>Рецепты</h1>
    <thead>
        <tr>
            <td><strong>Название</strong></td>
            <td><strong>Описание</strong></td>
            <td><strong>Приготовление</strong></td>
        </tr>
    </thead>
    <tbody>
            <tr>
                <?php if ($recipesData != null) {
                    foreach ($recipesData as $item) {
                        echo '<tr class="recipe_header">';
                        echo '<td class="recipes_names">' . $item->getName() . '</td>';
                        echo '<td class="recipes_descriptions">' . $item->getDescription() . '</td>';
                        echo '<td class="recipes_makings">' . $item->getMaking() . '</td>';
                        echo '</tr>';
                        echo '<tr class="recipe_ingridients">';
                        echo '<td valign="top"><form method="POST" action="/recipes/update"><input type="hidden" name="recipeid" value="' . $item->getId() . '"><button type="submit">Правка</button></form>';
                        echo '<p><form method="POST" action="/recipes/delete"><button formaction="/recipes/delete" name="id" value="' . $item->getId() . '">Удалить</button></form></p></td>';
                        echo '<td></td>';
                        echo '<td><strong>Ингридиенты: </strong><br><br>';
                        foreach ($item->getIngridients() as $itemIngridient) {
                            echo '<form method="POST" action="/recipes/manage/delete_ingridient">';
                            echo '<input type="hidden" name="recipeid" value="' . $item->getId() . '">';
                            echo '<input type="hidden" name="ingridientid" value="' . $itemIngridient['id'] . '">';
                            echo $itemIngridient['name'];
                            echo ' <button type="submit">X</button></form>';
                            echo '<br>';
                        };
                        echo '<form method="POST" action="/recipes/manage/add_ingridient">';
                        echo '<input type="hidden" name="recipeid" value="' . $item->getId() . '">';
                        echo '<select name="ingridientid">';
                        foreach ($ingridientsData as $itemIngridient) {
                            echo '<option value="' . $itemIngridient->getId() . '">' . $itemIngridient->getName() . '</option>';
                        }
                        echo '</select><button type="submit">Добавить</button></form></td>';
                        echo '</tr>';
                    }
                    echo '</tr></tbody></table>';
                    echo '<form method="POST" action="/recipes/create">';
                    echo '<input type="hidden" name="recipeid" value="' . $item->getId() . '">';
                    echo <<<END
                                <input name="name" value="Название" onclick="this.value = ''">
                                <input name="description" value="Описание" onclick="this.value = ''">
                                <input name="making" value="Приготовление" onclick="this.value = ''">
                                END;
                    echo '<button>Создать</button>';
                    echo '</form>';
} else {
                    header('Location: /login');
}