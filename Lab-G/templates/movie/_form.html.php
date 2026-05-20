<?php
    /** @var $movie ?\App\Model\Movie */
?>

<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="movie[title]" value="<?= $movie ? $movie->getTitle() : '' ?>">
</div>

<div class="form-group">
    <label for="producer">Producer</label>
    <input type="text" id="producer" name="movie[producer]" value="<?= $movie ? $movie->getProducer() : '' ?>">
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="movie[description]"><?= $movie? $movie->getDescription() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
