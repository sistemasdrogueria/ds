<?= $this->Html->css('tickets/tickets_indexAdmin') ?>
<script>
    $(function() {
        $("#datepicker").datepicker();
    });
</script>
<article class="module width_4_quarter">
    <header>
        <h3 class="tabs_involved"><?= $titulo ?></h3>
    </header>
    <div class="tab_container">
        <?php
        echo $this->element('ticket_search_admin');
        echo $this->element('ticket_result_admin'); ?>
    </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->