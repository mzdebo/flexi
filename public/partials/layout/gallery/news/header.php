<style>
  .flexi_list_cards {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;

  }

  .flexi_list_cards__item {
    display: flex;
    padding: 1rem;
  }

  @media (min-width: 40rem) {
    .flexi_list_cards__item {
      width: 50%;
    }
  }

  @media (min-width: 56rem) {
    .flexi_list_cards__item {
      width: <?php echo 100 / $perrow; ?>%;
    }
  }

  .flexi_list_card {
    background-color: white;
    border-radius: 0.25rem;
    box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    width: 100%;
  }

  .flexi_list_card:hover .flexi_list_card__image {
    -webkit-filter: contrast(100%);
    filter: contrast(100%);
  }

  .flexi_list_card__content {
    display: flex;
    flex: 1 1 auto;
    flex-direction: column;
    padding: 1rem;
  }

  .flexi_list_card__image {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    -webkit-filter: contrast(70%);
    filter: contrast(70%);
    overflow: hidden;
    position: relative;
    transition: -webkit-filter 0.5s cubic-bezier(0.43, 0.41, 0.22, 0.91);
    transition: filter 0.5s cubic-bezier(0.43, 0.41, 0.22, 0.91);
    transition: filter 0.5s cubic-bezier(0.43, 0.41, 0.22, 0.91), -webkit-filter 0.5s cubic-bezier(0.43, 0.41, 0.22, 0.91);
  }

  .flexi_list_card__image::before {
    content: "";
    display: block;
    padding-top: 56.25%;
  }

  @media (min-width: 40rem) {
    .flexi_list_card__image::before {
      padding-top: 66.6%;
    }
  }

  .flexi_list_card__title {
    color: #696969;
    font-weight: 300;
    letter-spacing: 2px;
    text-transform: uppercase;
  }

  .flexi_list_card__text {
    flex: 1 1 auto;

    margin-bottom: 1.25rem;
  }

  flexi_figcaption {
    display: none;
  }
</style>
<script>
jQuery(document).ready(function() {

    jQuery('[data-fancybox]').fancybox({
        caption: function(instance, item) {
            return jQuery(this).find('flexi_figcaption').html();
        }
    });
});
</script>
<div id="flexi_gallery">
  <ul class="flexi_list_cards">
