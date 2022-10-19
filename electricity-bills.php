<?php include('header.php') ?>
<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        background-color: #f8f8f8;
    }

    /* Style the buttons that are used to open the tab content */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        color: #999;
        font-size: 14px;
    }

    /* Change background color of buttons on hover */
    /* .tab button:hover {
        background-color: #000;
    } */
    /* Create an active/current tablink class */
    .tab button.active {
        border-bottom: 2px solid #1e6ad8;
        color: black;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
    }
</style>
<!-- modal -->
<div class="modal fade" id="detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Participate in the Lucky Draw to win 100% cashback upto ₹10,000.</h5>
                <button type="button" class="close border-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="myInput" readonly value="ELEC1000" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="myFunction()" id="basic-addon2" style="cursor: pointer;">Copy</span>
                        </div>
                    </div>
                </div>
                <div class="CLNZ lHgm">
                    <div> <b>Terms &amp; Conditions:</b></div>
                    <p>* Get a chance to win 100% Cashback on successful Electricity Bill Payment on Paytm app<br> 
                    * This offer is only applicable on min. bill payment of Rs.100 or more on Paytm app<br>
                    * Everyday 1000th users will receive 100% cashback upto Rs 10,000 on payment of electricity bill <br> 
                    * To avail this offer, Apply Promocode ELEC1000 in the 'Apply Promocode/See Bank offers' section<br> 
                    * This offer is applicable once per user per month<br> 
                    * This offer is valid till 31st October 2022, 23:59:00 only<br> 
                    * This offer cannot be clubbed with any other offer<br> 
                    * Cashback will be sent to the user's wallet instantly. In case of any delays, cashback will be credited within 24 hours from the completion of an eligible payment<br> 
                    * Paytm will not share a list of winners on its platform. All winners will get the cashback into their wallet instantly. There is no need to redeem a scratch card <br> 
                    * In case the user has exhausted min. KYC Limits of wallet, cashback will be sent to users in their Paytm linked Bank Account<br> 
                    * Paytm reserves its absolute right to withdraw and/or alter any terms and conditions of the offer at any time without prior notice<br>
                </p>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Hello! Krishana Cyber Cafe</h1>
                        <p>At a glance summary of your account. Have fun!</p>
                    </div>
                    <div>
                        <a href="" class="btn btn-link btn-soft-light">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z" fill="currentColor"></path>
                                <path opacity="0.4" d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z" fill="currentColor"></path>
                            </svg>
                            Announcements
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-header-img">
        <img src="assets/images/dashboard/top-header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        <img src="assets/images/dashboard/top-header1.png" alt="header" class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
        <img src="assets/images/dashboard/top-header2.png" alt="header" class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
        <img src="assets/images/dashboard/top-header3.png" alt="header" class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
        <img src="assets/images/dashboard/top-header4.png" alt="header" class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
        <img src="assets/images/dashboard/top-header5.png" alt="header" class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
    </div>
</div> <!-- Nav Header Component End -->
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">Pay Electricity Bill</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="recharge_form">
                            <div class="form-group">
                                <label class="form-label" for="pwd">State:</label>
                                <select class="form-select mb-3 shadow-none">
                                    <option selected="">Select State</option>
                                    <option value="1">Bihar</option>
                                    <option value="2">Assam</option>
                                    <option value="3">Chandigarh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pwd">Electricity Board:</label>
                                <select class="form-select mb-3 shadow-none">
                                    <option selected="">Select Electricity Board</option>
                                    <option value="1">Central Power Distribution Corporation of A.P Ltd (APCPDCL)</option>
                                    <option value="2">Eastern Power Distribution Company of Andhra Pradesh Ltd. (APEPDCL)</option>
                                    <option value="3">Southern Power Distribution Company of A.P Ltd (APSPDCL)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pwd">Consumer Number:</label>
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="pwd">
                            </div>
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">Promo Codes</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="_1s0u">
                            <ul>
                                <li class="p-2" data-bs-toggle="modal" data-bs-target="#detail_modal">
                                    <h5>ELEC1000</h5>
                                    <p class="m-0">
                                        <span class="_33La">Participate in the Lucky Draw to win 100% cashback upto ₹10,000.</span>
                                        <span class="YGVM"><span>View detail</span></span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php') ?>
<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
}

</script>