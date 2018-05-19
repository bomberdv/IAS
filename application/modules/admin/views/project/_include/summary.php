<style>
    table tr{
        height: 60px;
    }
</style>
<table class="table">

    <tbody>
    <tr>
        <th><?= lang('name') ?></th>
        <td><?= $project->title ?></td>

    </tr>
    <tr>
        <th><?= lang('priority') ?></th>
        <td><?= $project->priority ?></td>

    </tr>
    <tr>
        <th><?= lang('status') ?></th>
        <td><?= $project->status ?></td>
    </tr>
    <tr>
        <th><?= lang('status') ?></th>
        <td>
            <input type="range" min="1" max="100" value="10" class="slider" id="myRange">
            <p><span id="demo"></span> %</p>
        </td>
    </tr>
    <?php $customer = $this->db->get_where('customer', array('id' => $project->customer_id))->row();?>
    <tr>
        <th><?= lang('customer') ?></th>
        <td>
            <?= $customer->customer_code.' - '.$customer->name ?>
            <p><?= $customer->email ?></p>
        </td>
    </tr>

    <tr>
        <th><?= lang('start_date') ?></th>
        <td><?= dateFormat($project->start_date) ?></td>
    </tr>

    <tr>
        <th><?= lang('due_date') ?></th>
        <td><?= dateFormat($project->due_date) ?></td>
    </tr>

    <tr>
        <th><?= lang('budget') ?></th>
        <td><?php echo get_option('currency_symbol').' '?><?= currency($project->budget) ?></td>
    </tr>
    <tr>
        <th><?= lang('note') ?></th>
        <td><?= $project->note ?></td>
    </tr>

    </tbody>
</table>

<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>