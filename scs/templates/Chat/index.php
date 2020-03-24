</head>
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
                'class' => 'button'
            ]
        );
        echo $this->Form->end();
    ?>
</div>
<div>
    <table>
        <?php foreach ($feeds as $key => $feed): ?>
            <tr>
                <td>
                    <?= $feed->name?>
                </td>
                <td>

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
                        echo $this->Form->button('Edit', ['onclick' => "hideOrShow($key)"]);
                    ?>
                </td>
            </tr>
            <tr>
                <td id="hidden-form<?= $key ?>" style="display:none">
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