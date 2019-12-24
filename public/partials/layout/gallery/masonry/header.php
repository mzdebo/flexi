<style>
.flexi_masonry {
    columns: 1;
    column-gap: 10px;
}

.flexi_masonry-item img {
    max-width: 100%;
    vertical-align: middle;
}

.flexi_masonry-item {
    display: inline-block;
    vertical-align: top;
    margin-bottom: 10px;
}

@media only screen and (max-width: 1023px) and (min-width: 768px) {
    .flexi_masonry {
        columns: 2;
    }
}

@media only screen and (min-width: 1024px) {
    .flexi_masonry {
        columns: 3;
    }
}

.flexi_masonry-item,
.flexi_masonry-content {
    border-radius: 4px;
    overflow: hidden;
}

.flexi_masonry-item {
    filter: drop-shadow(0px 2px 2px rgba(0, 0, 0, .3));
    transition: filter .25s ease-in-out;
}

.flexi_masonry-item:hover {
    filter: drop-shadow(0px 5px 5px rgba(0, 0, 0, .3));
}
</style>
<div id="flexi_gallery">
    <flexi>
        <div class="flexi_masonry">