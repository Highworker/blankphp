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
        foreach($data as $item) {
            echo '<tr class="ingridient_row">';
            echo '<td>' . $item->getName() . '</td>';
            echo '<td>' . $item->getDescription() . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>