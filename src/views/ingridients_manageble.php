<table>
    <h1>Ингридиенты</h1>
    <thead>
    <tr>
        <td><strong>Название</strong></td>
        <td><strong>Описание</strong></td>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach($ingridientsData as $item) {
            echo '<tr class="ingridient_row">';
            echo '<td>' . $item->getName() . '</td>';
            echo '<td>' . $item->getDescription() . '</td>';
            echo '<td><form method="POST" action="/ingridients/update">';
            echo '<input type="hidden" value="'. $item->getId() .'" name="id">';
            echo '<button>Правка</button></form></td>';
            echo '<form method="POST" action="/ingridients/delete">';
            echo '<td><input type="hidden" value="'. $item->getId() .'" name="id">';
            echo '<button>X</button></td>';
            echo '</form>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<form method="POST" action="/ingridients/create">';
        echo <<<END
            <input name="name" value="Название" onclick="this.value = ''">
            <input name="description" value="Описание" onclick="this.value = ''">
        END;
        echo '<button>Создать</button>';
        echo '</form>';