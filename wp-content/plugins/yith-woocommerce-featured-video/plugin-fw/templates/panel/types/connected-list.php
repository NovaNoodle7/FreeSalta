<?php
$id = $this->get_id_field( $option['id'] );
$name = $this->get_name_field( $option['id'] );
?>

<div id="<?php echo $id ?>-container" class="yit_options rm_option rm_input rm_text rm_connectedlist" <?php if( isset( $option['deps'] ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $this->get_id_field( $option['deps']['ids'] ) ?>" data-value="<?php echo $option['deps']['values'] ?>" <?php endif ?>>
    <div class="option">
        <?php $yit_option = json_decode( stripslashes( $db_value ), true ); ?>
        <?php $lists = is_array($yit_option) ? $yit_option : $option['lists']; ?>

        <?php foreach( $lists as $list => $options ): ?>
            <div class="list_container">
                <h4><?php echo $option['heads'][ $list ] ?></h4>
                <ul id="list_<?php echo $list ?>" class="connectedSortable" data-list="<?php echo $list ?>" <?php echo $custom_attributes ?>>
                    <?php foreach( $options as $value => $label ): ?>
                        <li data-option="<?php echo $value ?>" class="ui-state-default"><?php echo $label ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endforeach ?>
        <input type="hidden" name="<?php echo $name ?>" id="<?php echo $id ?>" value='<?php echo esc_attr( $db_value ) ?>' />
    </div>
    <div class="description">
        <?php echo $option['desc'] ?>
    </div>
    <div class="clear"></div>
</div>