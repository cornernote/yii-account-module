<?php
/**
 * @var CController $this
 */
Yii::app()->bootstrap->register();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<body id="top" class="<?php echo $this->id . '-' . $this->action->id; ?>">
<?php echo $content; ?>
</body>
</html>