<h2>Naujausi skelbimai</h2>

<table>
    <div class="box">
        <tr>
            <th>Pavadinimas</th>
            <th>Kaina</th>
            <th>Metai</th>
        </tr>
        <tr><?php foreach ($this->data['ads'] as $ad): ?>
            <td>
                <a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a>
            </td>
            <td><?php echo $ad->getPrice() . '&#128 '; ?></td>
            <td><?php echo $ad->getYear() . ' '; ?> </td>
            <td><img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'">
            </td>
        </tr>
    </div>
    <?php endforeach; ?>
</table>

<h2>Populiariausi skelbimai</h2>
<table>
    <div class="box">
        <tr>
            <th>Pavadinimas</th>
            <th>Kaina</th>
            <th>Metai</th>
        </tr>
        <tr><?php foreach ($this->data['ad'] as $ad): ?>
            <td>
                <a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a>
            </td>
            <td><?php echo $ad->getPrice() . '&#128 '; ?></td>
            <td><?php echo $ad->getYear() . ' '; ?> </td>
            <td><img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'">
            </td>
        </tr>
    </div>
    <?php endforeach; ?>
</table>
