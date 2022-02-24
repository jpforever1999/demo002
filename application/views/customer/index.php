<section class="banner">
    <div class="container">
        <div class="row banner-box">
              <div class="col-md-2 pll prr d-menu">
                <ul class="side-bar" id="GetCategory">
                </ul>
            </div>


            <div class="col-md-7">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" id="BannerHome">
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 pll">
                <div class="women">
                    <figure class="snip0015">
                        <img src="/assets/frontend/images/women.jpg" class="img-fluid" alt="sample38"/>
                        <figcaption>
                            <h2>Women's</h2>
                            <a href="#">Shop Now</a>
                        </figcaption>
                    </figure>
                    <figure class="snip0015 mt-3">
                        <img src="/assets/frontend/images/men.jpg" class="img-fluid" alt="sample38"/>
                        <figcaption>
                            <h2>Men's</h2>
                            <a href="#">Shop Now</a>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-3 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-3 pll">
                <div class=" h-box">
                    <img class="img-fluid" src="/assets/frontend/images/free_icon.png">
                    <h2>Free  Shipping<span><br>Order Over $200</span></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class=" h-box">
                    <img class="img-fluid" src="/assets/frontend/images/payment_icon.png">
                    <h2>Quick Payment<span><br>100% Secure Payment</span></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class=" h-box">
                    <img class="img-fluid" src="/assets/frontend/images/gift_icon.png">
                    <h2>Gift Certificate<span><br>Buy Now $500 to $1000</span></h2>
                </div>
            </div>
            <div class="col-md-3 prr">
                <div class=" h-box">
                    <img class="img-fluid" src="/assets/frontend/images/support_icon.png">
                    <h2>24/7 Support<span><br>Ready Support</span></h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="featured">
    <div class="container pll prr">
        <h1 class="featured-head mb-3">Top categories</h1>
    </div>
    <div class="container white_box">
        <div class="row" id="FeaturedPro">
            
        </div>
        <div class="row pt-3 pb-3">
            <div class="container">
              <div class="row hp_slick1" id="FeaturedCat">
              </div>
            </div>
        </div>
    </div>


  <div class="container pll prr">
    <h1 class="featured-product featured-product2 mb-3">Featured Products</h1>
  </div>
  <div class="container">
      <div class="row hp_slick" id="FeaturedProduct">
      
      </div>

  </div>

    <div class="container white_box mt-4">
        <div class="row" id="BannerStripOne">
    
        </div>
    </div>
</section>

<section class="arrivals">
    <div class="container pll prr">
        <h1 class="featured-head featured-head2 mb-3">New Arrivals</h1>
    </div>
    <div class="container">
        <div class="row hp_slick text-center " id="NewArrivals">

        </div>
    </div>
</section>

<section class="products">
    <div class="container pll prr">
        <h1 class="featured-head featured-head3 mb-4 mt-4">Best Deals</h1>
    </div>
    <div class="container">
        <div class="row hp_slick text-center" id="BestDeals">
        </div>
    </div>
    <div class="container white_box">
        <div class="row">
            <div class="col-md-5">
                <a href="<?= base_url();?>taxonomy/clothing">
                <img src="/assets/frontend/images/f1.png" alt="" class="img-fluid mbb w-100">
                </a>
            </div>
            <div class="col-md-3 pt-0 pll prr">
                <a href="<?= base_url();?>taxonomy/clothing">
                <img src="/assets/frontend/images/f2.png" alt="" class="img-fluid mbb w-100">
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= base_url();?>taxonomy/clothing">
                <img src="/assets/frontend/images/f3.png" alt="" class="img-fluid w-100">
                </a>    
                <a href="<?= base_url();?>taxonomy/clothing">
                <img src="/assets/frontend/images/f4.png" alt="" class="img-fluid mt-3 w-100">
                </a>
            </div>
        </div>
    </div>
</section>

    <section class="arrivals">
      <div class="container pll prr">
        <h1 class="top-rated top-rated2 mb-3">TOP RATED PRODUCTS</h1>
          </div>
      <div class="container">
          <div class="row hp_slick text-center" id="TopRatedProducts">

          </div>
      </div>
  </section>


<!--<section class="latest-product">
    <div class="container">
        <div class="row">
            <div class="col-md-9 pll">
                <div class="row">
                    <div class="col-md-4 dpg mbb">
                        <h1 class="tp-head">Top Rated Products</h1>
                        <div id="TopRated"></div>
                    </div>
                    <div class="col-md-4 dpg mbb">
                        <h1 class="tp-head">Best Selling Products</h1>
                        <div id="BestSelling"></div>
                    </div>
                    <div class="col-md-4 dpg">
                        <h1 class="tp-head">Latest Products</h1>
                        <div id="Latest"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 prr">
                <a href="#">
                <img src="/assets/frontend/images/shoe.png" alt="" class="img-fluid  w-100">
                </a>
            </div>
        </div>
    </div>
</section>-->

<script>

 $(document).on('hover', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

$(document).ready(function() {

    // TOP RATED BSEST AND LATEST PRODUCTS FUNCTION //
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    //postData.home_page = 1;
    postData.length = 3;
    var request = $.ajax({
      url: "welcome/ajax-home",
      type: "POST",
      data: postData,
      dataType: "json"
    }); 

request.done(function(response) {
        var rated_html =  selling_html = latest_html = '';
        if(response.status == '1'){
            var data = response.data;
            var top_rated_cnt=0;
            $.each(data.top_rated_products, function(key, row) {
              top_rated_cnt++;
                rated_html+='<a href="'+row.url+'">'+
                                '<div class="small-p mb-5">'+
                                    '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                                    '<h2><small>Category</small><br>'+row.post_title+'</h2>'+
                                    '<a href="'+row.url+'">$'+row.sale_price+'</a>'+
                                '</div>'+
                            '</a>';
                if(top_rated_cnt == 3)
                {
                    return false;
                }
            });

            var bestselling_cnt=0;
            $.each(data.best_deals, function(key, row) {
                bestselling_cnt++;
                selling_html+='<a href="'+row.url+'">'+
                                '<div class="small-p mb-5">'+
                                    '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                                    '<h2><small>Category</small><br>'+row.post_title+'</h2>'+
                                    '<a href="'+row.url+'">$'+row.sale_price+'</a>'+
                                '</div>'+
                            '</a>';
                if(bestselling_cnt == 3)
                {
                    return false;
                }
            });
            best_deals(data.best_deals);

            var latest_cnt=0;
            $.each(data.new_arrivals, function(key, row) {
                latest_cnt++;
                latest_html+='<a href="'+row.url+'">'+
                                '<div class="small-p mb-5">'+
                                    '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                                    '<h2><small>Category</small><br>'+row.post_title+'</h2>'+
                                    '<a href="'+row.url+'">$'+row.sale_price+'</a>'+
                                '</div>'+
                            '</a>';
                if(latest_cnt == 3)
                {
                    return false;
                }
            }); 

             featured_product(data.featured_product);
             new_arrivals(data.new_arrivals);
             top_categories(data.top_category); 
             top_rated_products(data.top_rated_products);
            $(".hp_slick").slick(getSliderSettings());
            $(".hp_slick1").slick(getSliderSettings());
        }
       
        get_home_page_banner(data.home_banner);
        top_categories_banner(data.top_cat_banner_web);
        banner_strip_one(data.banner_strip_one);
        rated_html = rated_html ? rated_html : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('#TopRated').html(rated_html);
        $('#BestSelling').html(selling_html);
        $('#Latest').html(latest_html);
    });

//THIS FUNCTION USE FOR BANNER STRIP ONE
function get_home_page_banner(home_banner)
{
    //alert(home_banner)
    var BannerHome_html ='';
    var mainStrip = home_banner;
    var count = mainStrip.length;
    var mainStripcnt = 0;
    $.each(mainStrip, function(key, row) {
     mainStripcnt++;
    if(mainStripcnt == 1){
        var activeclass = 'active';
    }
    BannerHome_html+='<div class="carousel-item '+activeclass+'">'+
                            '<img class="d-block w-100" src="'+row.banner_image+'" alt="Third slide" width="'+row.width+'" height="'+row.height+'">'+
                       '</div>';
        }); 

    BannerHome_html = BannerHome_html ? BannerHome_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#BannerHome').html(BannerHome_html);
}


function top_categories_banner(top_cat_banner_web)
{
    var FeaturedCategories_html ='';
    var mainStrip = top_cat_banner_web;
    var ShopNow = 'Shop Now';
    $.each(mainStrip, function(key, row) {
      FeaturedCategories_html+='<div class="col-md-4">'+
                '<div class="featured-box d-flex">'+
                    '<div class="head pl-3 pr-3">'+
                        '<h3>'+
                            '<small>'+row.title+'</small>'+
                            '<br>Deals'+
                        '</h3>'+
                        '<a href="'+row.url+'">'+ShopNow+'</a>'+
                    '</div>'+
                    '<img src="'+row.banner_image+'" alt="" class="img-fluid">'+
                '</div>'+
            '</div>';
    }); 

    FeaturedCategories_html = FeaturedCategories_html ? FeaturedCategories_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#FeaturedPro').html(FeaturedCategories_html);

}


function top_categories(top_category)
{
    var FeaturedCat_html ='';
    $.each(top_category, function(key, row) {
    FeaturedCat_html+='<a href="/taxonomy/'+row.slug+'">'+
                    '<div>'+
                        '<div class="white_box cattitle p-2 text-center">'+
                          '<img src="'+row.thumbnail+'" alt="" title="'+row.name+'" class="img-fluid">'+
                          '<h4>'+row.name+'</h4>'+
                        '</div>'+
                    '</div>'+
                    '</a>';
        }); 

    FeaturedCat_html = FeaturedCat_html ? FeaturedCat_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#FeaturedCat').html(FeaturedCat_html);
}


function featured_product(featured_product)
{
    var FeaturedProduct_html ='';
    var add_to_cart = 'ADD TO CART';
    var addtocart = 'addtocart-';
    $.each(featured_product, function(key, row) {
    FeaturedProduct_html+='<div style="width: 100%; display: inline-block;">'+
                        '<div class="white_box p-2 text-center">'+
                            '<a href="'+row.url+'">'+
                                '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                            '<h4>'+row.post_title+'</h4>'+
                            '<h6>$'+row.sale_price+'</h6>'+
                            '</a>'+
                             '<form class="contact-form-box cart" id="'+addtocart+row.product_id+'" method="post" enctype="multipart/form-data">'+
                            '<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />'+
                            '<button type="button" name="add-to-cart" data-product-id="'+row.product_id+'" data-variation-id="0" data-quantity="1" class="add_to_cart">'+add_to_cart+'</button>'+
                            '</form>'+
                            //'<a href="#" class="add_to_cart">Add to cart</a>'+
                        '</div>'+
                    '</div>';
    }); 

    FeaturedProduct_html = FeaturedProduct_html ? FeaturedProduct_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#FeaturedProduct').html(FeaturedProduct_html);
}



function banner_strip_one(banner_strip_one)
{
    var BannerStripOne_html ='';
    $.each(banner_strip_one, function(key, row) {
    BannerStripOne_html+='<div class="col-md-4 mbb">'+
                          '<a href="'+row.url+'">'+
                            '<img src="'+row.banner_image+'" class="img-fluid w-100" alt="'+row.title+'"/>'+
                          '</a>'+    
                      '</div>';
           }); 

    BannerStripOne_html = BannerStripOne_html ? BannerStripOne_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#BannerStripOne').html(BannerStripOne_html);

}


function new_arrivals(datalatest)
{   
    var NewArrivals_html ='';
    var add_to_cart = 'ADD TO CART';
    var addtocart = 'addtocart-';
    $.each(datalatest, function(key, row) {
    NewArrivals_html+='<div style="width: 100%; display: inline-block;">'+
                        '<div class="white_box p-2 text-center">'+
                            '<a href="'+row.url+'">'+
                                '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                            '<h4>'+row.post_title+'</h4>'+
                            '<h6>$'+row.sale_price+'</h6>'+
                            '</a>'+
                            '<form class="contact-form-box cart" id="'+addtocart+row.product_id+'" method="post" enctype="multipart/form-data">'+
                            '<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />'+
                            '<button type="button" name="add-to-cart" data-product-id="'+row.product_id+'" data-variation-id="0" data-quantity="1" class="add_to_cart">'+add_to_cart+'</button>'+
                            '</form>'+
                        '</div>'+
                    '</div>';
    }); 

    NewArrivals_html = NewArrivals_html ? NewArrivals_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#NewArrivals').html(NewArrivals_html);
    
}


function best_deals(best_deals)
{   
    var BestDeals_html ='';
    var add_to_cart = 'ADD TO CART';
    var addtocart = 'addtocart-';
    $.each(best_deals, function(key, row) {
    BestDeals_html+='<div style="width: 100%; display: inline-block;">'+
                        '<div class="white_box p-2 text-center">'+
                            '<a href="'+row.url+'">'+
                            '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                            '<h4>'+row.post_title+'</h4>'+
                            '<h6>$'+row.sale_price+'</h6>'+
                            '</a>'+
                             '<form class="contact-form-box cart" id="'+addtocart+row.product_id+'" method="post" enctype="multipart/form-data">'+
                            '<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />'+
                            '<button type="button" name="add-to-cart" data-product-id="'+row.product_id+'" data-variation-id="0" data-quantity="1" class="add_to_cart">'+add_to_cart+'</button>'+
                            '</form>'+
                        '</div>'+
                    '</div>';
    }); 

    BestDeals_html = BestDeals_html ? BestDeals_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#BestDeals').html(BestDeals_html);
    
}


function top_rated_products(top_rated_products)
{   
    var TopRated_html ='';
    var add_to_cart = 'ADD TO CART';
    var addtocart = 'addtocart-';
    $.each(top_rated_products, function(key, row) {
    TopRated_html+='<div style="width: 100%; display: inline-block;">'+
                        '<div class="white_box p-2 text-center">'+
                            '<a href="'+row.url+'">'+
                            '<img src="'+row.featured_image+'" alt="" class="img-fluid">'+
                            '<h4>'+row.post_title+'</h4>'+
                            '<h6>$'+row.sale_price+'</h6>'+
                            '</a>'+
                             '<form class="contact-form-box cart" id="'+addtocart+row.product_id+'" method="post" enctype="multipart/form-data">'+
                            '<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />'+
                            '<button type="button" name="add-to-cart" data-product-id="'+row.product_id+'" data-variation-id="0" data-quantity="1" class="add_to_cart">'+add_to_cart+'</button>'+
                            '</form>'+
                        '</div>'+
                    '</div>';
    }); 

    TopRated_html = TopRated_html ? TopRated_html : '<div class="container small-p mb-5">There is no information to display.</div>';
    $('#TopRatedProducts').html(TopRated_html);
    
}

 });

</script>
