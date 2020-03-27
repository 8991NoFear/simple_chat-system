<script>
    function hideOrShow(key) {
        var element = document.getElementById("hidden-form" + key);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>
</style>
<div>
    <?php
        echo $this->Form->create(null, array('url' => ['action' => 'post'], 'type' => 'file'));
        echo $this->Form->control('name');
        echo $this->Form->control('message');
        echo $this->Form->control('media', ['type' => 'file']);
        echo $this->Form->button(__('POST'));
        echo $this->Html->link(
            'LOGOUT',
            [
                'controller' => 'Users',
                'action' => 'logout',
            ],
            ['class' => 'custom-link']
        );
        echo $this->Form->end(); 
    ?>
</div>
<div>
    <table>
        <?php foreach ($feeds as $feed): ?>
            <tr>
                <td>
                    <?= $feed->name?>
                </td>
                <td>
                    <?php
                        if ($feed->image_file_name != null) {
                            echo "<img src = '$feed->image_file_name' width = '320' height= '240' />";
                        } else if ($feed->video_file_name != null) {
                            echo "<video width = '320' height= '240' controls>";
                            echo "<source src =  '$feed->video_file_name'/>";
                            echo "Your browser does not support this video!!!";
                            echo "</video>";
                        }
                    ?>
                </td>
                <td>
                    <?= $feed->message?>
                </td>
                <td>
                    <?= $feed->update_at->format(DATE_RFC850) ?>
                </td>
                <td>
                    <?= $this->Html->link(
                        'Delete',
                        ['action' => 'delete', $feed->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $feed->id), 'class' => 'side-nav-item']
                        ) ?>
                </td>
                <td>
                    <?php
                        echo $this->Form->button('Edit', ['onclick' => "hideOrShow($feed->id)"]);
                    ?>
                </td>
            </tr>
            <tr>
                <td id="hidden-form<?= $feed->id; ?>" style="display:none">
                    <?php
                        echo $this->Form->create(null, array('url' => ['action' => 'edit', $feed->id]));
                        echo $this->Form->control('name');
                        echo $this->Form->control('message');
                        echo $this->Form->button(__('CHANGE'));
                        echo $this->Form->end();
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>