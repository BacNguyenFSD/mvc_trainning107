<html>
    <head>
        <title><?php echo (!empty($page_title)?$page_title:'Trang chủ website'); ?></title>
        <meta charset="utf-8"/>
        <link rel="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/style.css">
    </head>
</html>
<body>
    <?php 
        $this->redner('blocks/header');
        $this->redner($content, $sub_content);
        $this->redner('blocks/footer');
    ?>
    <script type="text/javascript" src="<?php echo _WEB_ROOT;?>/public/assets/clients/js/script.js"></script>
</body>
</html>