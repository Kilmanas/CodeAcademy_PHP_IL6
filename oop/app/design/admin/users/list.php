<?php
/**
 * @var \Model\User $user ;
 */
?>
<form action="<?= $this->url('Admin/changeUserStatus') ?>" method="POST">
<table>
    <tr>
        <th>#</th>
        <th>Id</th>
        <th>Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($this->data['users'] as $user): ?>
        <tr>
            <td><input type="checkbox" name="collection[]" value="<?= $user->getId()?>"></td>
            <td><?= $user->getId(); ?></td>
            <td><?= $user->getName(); ?></td>
            <td><?= $user->getLastName(); ?></td>
            <td><?= $user->getEmail(); ?></td>
            <td><?= $user->getPhone(); ?></td>
            <td><?= $user->getActive(); ?></td>
            <td>
                <a href="<?= $this->url('admin/useredit', $user->getId()) ?>">Edit</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    <select name="action">
        <option value="0">Deaktyvuoti</option>
        <option value="1">Aktyvuoti</option>
    </select>
    <input type="submit" value="keisti">
</form>