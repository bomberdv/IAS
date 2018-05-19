<?php

echo '<pre>';
print_r($this->cart->contents());
echo '</pre>';

?>
<style>
    table td {
        border-top: none !important;
    }
     .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 5px;

    }
</style>
<a  href="javascript:void(0);" class="addTire btn btn-info "><i class="fa fa-plus"></i> Add </a>
<div class="table-responsive">
    <table class="table" id="tireFields">
        <thead>

        <tr style="background-color: #ECEEF1">
            <th class="col-sm-4"><?= lang('product/service') ?></th>
            <th class="col-sm-1"><?= lang('qty') ?></th>
            <th class="col-sm-2"><?= lang('rate') ?></th>
            <th class="col-sm-1"><?= lang('tax') ?></th>
            <th class="col-sm-2"><?= lang('tax') ?></th>
            <th class="col-sm-2"><?= lang('amount') ?></th>
            <th class=""> </th>
        </tr>
        </thead>
        <tbody>

        <?php $i=1; if(!empty($this->cart->contents())) { foreach ($this->cart->contents() as $cart) {?>

            <tr>

                <td>
                    <label><?php echo $cart['name']?></label>
                </td>


                <td>
                    <input class="form-control" type="text" name="qty" onblur ="updateItem(this);" value="<?php echo $cart['qty'] ?>" id="<?php echo 'qty'.$cart['rowid'] ?>" >
                </td>

                <td>
                    <input class="form-control" type="text" name="price" value="<?php echo $cart['price'] ?>" onblur ="updateItem(this);" id="<?php echo 'prc'.$cart['rowid'] ?>">
                </td>

                <td>
                    <input class="form-control" type="text" value="<?= $cart['tax_rate'] ?>" onblur ="updateItem(this);" id="<?php echo 'tax'.$cart['rowid'] ?>">
                </td>

                <td>
                    <label><?php echo  get_option('currency_symbol').' '.$this->localization->currencyFormat($cart['tax']) ?></label>
                </td>

                <td>
                    <label><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($cart['subtotal'] + $cart['tax']) ?></label>
                </td>

                <input type="hidden" name="product_code" value="<?php echo $cart['id']  ?>" id="<?php echo 'pid'.$cart['rowid'] ?>">

                <td>
                    <a href="javascript:void(0)" id="<?php echo $cart['rowid'] ?>" onclick="removeItem(this);"  class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a>
                </td>

            </tr>
            <tr>

            <?php if($cart['type']){ ?>
                <td >
                <?php echo $cart['description']?>
                </td>
                <td colspan="5">
                    <textarea class="form-control"  onblur ="updateItem(this);"></textarea>

                </td>
            <?php }else{ ?>
                <td colspan="6">
<!--                    <input class="form-control" type="text" name="description" onblur ="updateItem(this);" id="--><?php //echo 'des'.$cart['rowid'] ?><!--" value="--><?php //echo $cart['description']?><!--">-->
                    <textarea class="form-control" name="description" onblur ="updateItem(this);" id="<?php echo 'des'.$cart['rowid'] ?>"><?php echo $cart['description']?></textarea>
                </td>
            <?php } ?>

            </tr>

            <?php $i++; };} ?>

        <div class="form-group form-group-bottom">

        <tr>
            <td>
                <input type="text" class="form-control">
            </td>

            <td>
                <input class="form-control" type="text">
            </td>

            <td>
                <input class="form-control" type="text" >
            </td>

            <td>
                <input class="form-control" type="text">
            </td>

            <td>
                <label><?php echo  $this->localization->currencyFormat(0) ?></label>
            </td>

            <td>
                <label><?php echo  get_option('currency_symbol').' '.$this->localization->currencyFormat(0) ?></label>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <textarea class="form-control"></textarea>
            </td>
        </tr>
        </div>

        </tbody>
    </table>
</div>

<table class="table table-hover">
    <thead>

    <tr style="border-bottom: solid 1px #ccc">
        <th style="width: 15px"></th>
        <th class="col-sm-2"></th>
        <th class="col-sm-5"></th>
        <th class=""></th>
        <th class=""></th>
        <th style="width: 230px"></th>
    </tr>
    </thead>
    <tbody>
<!--    <tr>-->
<!--        <td colspan="5" style="text-align: right">-->
<!--            --><?//= lang('total') ?>
<!--        </td>-->
<!---->
<!--        <td style="text-align: right; padding-right: 30px">-->
<!--            --><?php //echo $this->cart->total(); ?>
<!--        </td>-->
<!---->
<!--    </tr>-->


    <?php if ($this->session->userdata('type') != 'quotation') { ?>

        <?php $total_tax = 0.00 ?>
        <?php if (!empty($this->cart->contents())): foreach ($this->cart->contents() as $item) : ?>
            <?php $total_tax += $item['tax'] ?>
        <?php endforeach; endif ?>
        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('tax') ?>
            </td>

            <td style="text-align: right; padding-right: 30px">
               <label> <?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($total_tax); ?></label>
            </td>

        </tr>

        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('discount') ?> %
            </td>

            <td style="text-align: right; padding-right: 30px">
                <input type="" class="form-control" style="text-align: right" onblur="order_discount(this)" value="<?php echo $this->session->userdata('discount');?>" name="discount">
            </td>

        </tr>
    <?php } ?>
    <tr>
        <td colspan="5" style="text-align: right; font-weight: bold">
            <?= lang('grand_total') ?>
        </td>

        <?php
        $gtotal =  $this->cart->total();
        $discount = $this->session->userdata('discount');

        $discount_amount = ($gtotal * $discount)/100;
        ?>

        <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px">
            <?php echo get_option('default_currency').' '.$this->localization->currencyFormat($gtotal + $total_tax - $discount_amount); ?>
        </td>

    </tr>


    </tbody>
</table>


<script lang="javascript">


    $(document).ready(function() {
        var id = 0;
        //***************** Tier Price Option Start *****************//
        $(".addTire").click(function() {
            id++;
            $("#tireFields").append(
                '<tr>\
                    <td>\
                <input type="text" class="form-control" name="">\
                </td>\
                <td>\
               <input class="form-control" type="text">\
                </td>\
                <td>\
                <input class="form-control" type="text" style="width:120px" >\
                </td>\
                <td>\
               <input class="form-control" type="text" style="width:120px" >\
            </td>\
             <td>\
               <?php echo get_option('currency_symbol') ?> 0.00\
            </td>\
            <td>\
            <input class="form-control" type="text" readonly style="width:120px">\
            </td>\
            <td><a href="javascript:void(0);" class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a></td>\
            </tr>\
            <tr>\
                <td colspan="6">\
                <input type="text" class="form-control">\
                </td>\
                </tr>'
            );

            set();

        });
        //***************** Tire Price Option End *****************//

        //Remove Tire Fields
        $("#tireFields").on('click', '.remTire', function() {
            $(this).closest('tr').next().remove();
            $(this).parent().parent().remove();
        });

        function set() {
            //$("#product").select2();
            $('select').select2();
        }

    });


</script>