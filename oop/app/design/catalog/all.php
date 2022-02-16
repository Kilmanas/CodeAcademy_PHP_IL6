
<table>
    <div class="box">
        <tr><th>Pavadinimas</th><th><a href="?order=price&&sort=<?php $sort?>">Kaina</a></th>
            <th><a href="?order=year&&sort=<?php $sort?>">Metai</a></th></tr>
    <tr><?php foreach ($this->data['ads'] as $ad):?>
        <td><a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle().' ';?></a></td>
        <td><?php echo $ad->getPrice().'&#128 ';?></td>
        <td><?php echo $ad->getYear().' ';?> </td>
        <td><img class="thumbnail" src="<?php echo $ad->getPictureUrl()?>" onerror="this.style.display='none'"></td>
    </tr></div>
<?php endforeach; ?>
    </table>
