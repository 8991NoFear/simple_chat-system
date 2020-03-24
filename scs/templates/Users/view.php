<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('E Mail') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->e_mail)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Password') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->password)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Username') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->username)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Feeds') ?></h4>
                <?php if (!empty($user->feeds)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Image File Name') ?></th>
                            <th><?= __('Video File Name') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('Update At') ?></th>
                            <th><?= __('Create At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->feeds as $feeds) : ?>
                        <tr>
                            <td><?= h($feeds->id) ?></td>
                            <td><?= h($feeds->name) ?></td>
                            <td><?= h($feeds->user_id) ?></td>
                            <td><?= h($feeds->image_file_name) ?></td>
                            <td><?= h($feeds->video_file_name) ?></td>
                            <td><?= h($feeds->message) ?></td>
                            <td><?= h($feeds->update_at) ?></td>
                            <td><?= h($feeds->create_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Feeds', 'action' => 'view', $feeds->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Feeds', 'action' => 'edit', $feeds->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Feeds', 'action' => 'delete', $feeds->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feeds->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
