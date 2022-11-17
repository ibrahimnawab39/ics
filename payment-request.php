<?php include('header.php') ?>
<!-- modal -->
<div class="modal fade" id="detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan & Pay</h5>
                <button type="button" class="close border-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <b>
                        <h4>Open any UPI or Bank's mobile app and scan this QR code</h4>
                        <h5> You will be prompted to enter your UPI PIN on the app</h5>
                    </b>
                    <br>
                    <!--?xml version="1.0" encoding="UTF-8"?-->
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="200" height="200" viewBox="0 0 200 200">
                        <rect x="0" y="0" width="200" height="200" fill="#ffffff"></rect>
                        <g transform="scale(5.405)">
                            <g transform="translate(0,0)">
                                <path fill-rule="evenodd" d="M10 0L10 2L11 2L11 0ZM12 0L12 1L13 1L13 0ZM14 0L14 2L15 2L15 3L13 3L13 2L12 2L12 4L16 4L16 5L14 5L14 8L13 8L13 9L12 9L12 7L13 7L13 5L11 5L11 6L10 6L10 4L11 4L11 3L8 3L8 4L9 4L9 5L8 5L8 7L9 7L9 8L6 8L6 9L8 9L8 10L11 10L11 9L12 9L12 10L13 10L13 11L12 11L12 13L15 13L15 12L16 12L16 11L18 11L18 12L17 12L17 13L16 13L16 14L15 14L15 15L14 15L14 16L13 16L13 17L12 17L12 15L13 15L13 14L11 14L11 13L10 13L10 14L9 14L9 15L7 15L7 14L6 14L6 15L7 15L7 16L6 16L6 17L7 17L7 16L9 16L9 18L8 18L8 20L9 20L9 21L10 21L10 22L6 22L6 23L8 23L8 24L6 24L6 25L8 25L8 24L9 24L9 23L10 23L10 24L11 24L11 25L9 25L9 26L8 26L8 27L7 27L7 26L5 26L5 24L4 24L4 23L5 23L5 21L7 21L7 20L5 20L5 19L3 19L3 18L4 18L4 17L5 17L5 16L2 16L2 17L1 17L1 16L0 16L0 17L1 17L1 20L2 20L2 24L1 24L1 21L0 21L0 24L1 24L1 25L0 25L0 29L1 29L1 25L2 25L2 29L4 29L4 28L6 28L6 29L7 29L7 28L10 28L10 29L11 29L11 27L9 27L9 26L11 26L11 25L12 25L12 26L13 26L13 25L14 25L14 26L15 26L15 27L16 27L16 26L15 26L15 25L14 25L14 24L16 24L16 25L19 25L19 26L18 26L18 27L19 27L19 26L20 26L20 25L21 25L21 26L22 26L22 27L21 27L21 28L20 28L20 29L19 29L19 28L15 28L15 29L14 29L14 28L13 28L13 27L12 27L12 29L14 29L14 30L15 30L15 33L16 33L16 34L14 34L14 33L12 33L12 31L13 31L13 30L11 30L11 32L10 32L10 30L9 30L9 29L8 29L8 31L9 31L9 32L8 32L8 37L9 37L9 32L10 32L10 33L12 33L12 34L13 34L13 35L12 35L12 37L13 37L13 36L14 36L14 37L16 37L16 36L17 36L17 37L21 37L21 36L22 36L22 35L23 35L23 36L24 36L24 37L28 37L28 36L30 36L30 37L33 37L33 36L34 36L34 37L37 37L37 33L36 33L36 32L33 32L33 31L34 31L34 29L35 29L35 31L37 31L37 30L36 30L36 29L37 29L37 26L36 26L36 25L37 25L37 22L35 22L35 20L37 20L37 18L36 18L36 17L35 17L35 16L33 16L33 15L34 15L34 13L36 13L36 11L37 11L37 10L36 10L36 11L35 11L35 9L36 9L36 8L35 8L35 9L34 9L34 8L33 8L33 9L34 9L34 11L35 11L35 12L34 12L34 13L33 13L33 12L31 12L31 10L32 10L32 8L31 8L31 10L30 10L30 11L29 11L29 10L27 10L27 9L30 9L30 8L29 8L29 5L27 5L27 4L29 4L29 3L27 3L27 4L26 4L26 3L25 3L25 2L26 2L26 1L27 1L27 2L29 2L29 1L27 1L27 0L26 0L26 1L24 1L24 3L23 3L23 0L21 0L21 1L20 1L20 0L19 0L19 1L18 1L18 0L16 0L16 1L15 1L15 0ZM8 1L8 2L9 2L9 1ZM17 1L17 2L16 2L16 4L17 4L17 3L19 3L19 4L18 4L18 5L17 5L17 8L16 8L16 6L15 6L15 8L16 8L16 9L17 9L17 10L18 10L18 11L19 11L19 12L18 12L18 13L17 13L17 14L16 14L16 16L18 16L18 17L19 17L19 16L21 16L21 17L20 17L20 18L19 18L19 19L18 19L18 18L17 18L17 20L19 20L19 21L18 21L18 22L17 22L17 24L19 24L19 25L20 25L20 24L21 24L21 25L22 25L22 26L23 26L23 27L22 27L22 28L21 28L21 29L20 29L20 30L19 30L19 29L17 29L17 30L16 30L16 29L15 29L15 30L16 30L16 31L17 31L17 32L18 32L18 30L19 30L19 31L20 31L20 30L21 30L21 29L22 29L22 28L23 28L23 29L24 29L24 28L26 28L26 27L27 27L27 28L28 28L28 27L29 27L29 28L30 28L30 27L31 27L31 28L33 28L33 29L34 29L34 28L35 28L35 27L34 27L34 24L35 24L35 25L36 25L36 23L35 23L35 22L33 22L33 21L34 21L34 20L35 20L35 19L36 19L36 18L35 18L35 17L34 17L34 18L33 18L33 17L32 17L32 16L31 16L31 17L30 17L30 16L29 16L29 15L32 15L32 14L33 14L33 13L32 13L32 14L31 14L31 13L30 13L30 14L29 14L29 13L27 13L27 12L28 12L28 11L27 11L27 12L26 12L26 9L27 9L27 8L28 8L28 6L27 6L27 7L26 7L26 4L20 4L20 3L21 3L21 2L20 2L20 1L19 1L19 2L18 2L18 1ZM19 4L19 5L18 5L18 8L17 8L17 9L18 9L18 10L20 10L20 9L21 9L21 10L22 10L22 11L21 11L21 12L20 12L20 13L19 13L19 14L20 14L20 13L21 13L21 16L22 16L22 17L23 17L23 18L21 18L21 20L20 20L20 21L19 21L19 22L20 22L20 21L21 21L21 20L23 20L23 21L22 21L22 22L21 22L21 24L23 24L23 22L24 22L24 24L25 24L25 26L24 26L24 25L23 25L23 26L24 26L24 27L23 27L23 28L24 28L24 27L25 27L25 26L26 26L26 25L31 25L31 26L32 26L32 27L33 27L33 26L32 26L32 25L33 25L33 24L34 24L34 23L33 23L33 24L31 24L31 22L32 22L32 21L33 21L33 19L32 19L32 18L30 18L30 17L29 17L29 16L27 16L27 17L26 17L26 16L25 16L25 17L24 17L24 16L23 16L23 15L22 15L22 13L23 13L23 12L25 12L25 13L26 13L26 15L28 15L28 14L27 14L27 13L26 13L26 12L25 12L25 10L24 10L24 11L23 11L23 10L22 10L22 9L21 9L21 8L22 8L22 7L23 7L23 5L21 5L21 6L20 6L20 7L19 7L19 5L20 5L20 4ZM9 6L9 7L10 7L10 6ZM11 6L11 7L12 7L12 6ZM21 6L21 7L20 7L20 8L19 8L19 9L20 9L20 8L21 8L21 7L22 7L22 6ZM24 6L24 9L26 9L26 8L25 8L25 6ZM0 8L0 10L1 10L1 9L5 9L5 8ZM10 8L10 9L11 9L11 8ZM13 9L13 10L14 10L14 9ZM4 10L4 11L5 11L5 12L4 12L4 13L8 13L8 12L11 12L11 11L7 11L7 10ZM1 11L1 14L0 14L0 15L1 15L1 14L2 14L2 15L3 15L3 14L2 14L2 13L3 13L3 12L2 12L2 11ZM6 11L6 12L7 12L7 11ZM13 11L13 12L14 12L14 11ZM22 11L22 12L21 12L21 13L22 13L22 12L23 12L23 11ZM10 14L10 15L9 15L9 16L10 16L10 17L11 17L11 20L10 20L10 18L9 18L9 20L10 20L10 21L11 21L11 22L10 22L10 23L11 23L11 22L13 22L13 23L12 23L12 25L13 25L13 24L14 24L14 23L15 23L15 22L14 22L14 21L15 21L15 20L14 20L14 19L15 19L15 18L16 18L16 17L15 17L15 18L12 18L12 17L11 17L11 14ZM36 14L36 15L37 15L37 14ZM18 15L18 16L19 16L19 15ZM2 17L2 18L3 18L3 17ZM25 17L25 19L24 19L24 18L23 18L23 19L24 19L24 20L25 20L25 21L24 21L24 22L25 22L25 24L27 24L27 22L28 22L28 23L30 23L30 22L31 22L31 21L26 21L26 17ZM27 17L27 18L28 18L28 19L29 19L29 20L32 20L32 19L30 19L30 18L29 18L29 17ZM6 18L6 19L7 19L7 18ZM12 19L12 21L14 21L14 20L13 20L13 19ZM3 20L3 21L4 21L4 20ZM2 24L2 25L3 25L3 26L4 26L4 27L3 27L3 28L4 28L4 27L5 27L5 26L4 26L4 24ZM27 26L27 27L28 27L28 26ZM29 26L29 27L30 27L30 26ZM6 27L6 28L7 28L7 27ZM25 29L25 30L23 30L23 31L22 31L22 32L21 32L21 33L20 33L20 32L19 32L19 33L17 33L17 34L16 34L16 35L14 35L14 36L16 36L16 35L17 35L17 36L18 36L18 34L19 34L19 36L20 36L20 34L21 34L21 35L22 35L22 34L23 34L23 35L25 35L25 36L26 36L26 35L27 35L27 36L28 36L28 35L30 35L30 36L31 36L31 34L28 34L28 33L26 33L26 34L25 34L25 33L24 33L24 34L23 34L23 33L22 33L22 32L24 32L24 31L25 31L25 32L26 32L26 31L28 31L28 29ZM29 29L29 32L32 32L32 29ZM25 30L25 31L26 31L26 30ZM30 30L30 31L31 31L31 30ZM19 33L19 34L20 34L20 33ZM34 33L34 34L32 34L32 36L33 36L33 35L34 35L34 36L36 36L36 35L35 35L35 33ZM10 35L10 37L11 37L11 35ZM0 0L0 7L7 7L7 0ZM1 1L1 6L6 6L6 1ZM2 2L2 5L5 5L5 2ZM30 0L30 7L37 7L37 0ZM31 1L31 6L36 6L36 1ZM32 2L32 5L35 5L35 2ZM0 30L0 37L7 37L7 30ZM1 31L1 36L6 36L6 31ZM2 32L2 35L5 35L5 32Z" fill="#000000"></path>
                            </g>
                        </g>
                    </svg>
                    <hr>
                    Post successful payment, balance will reflect in your Pay2all within 5 minutes
                </center>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-2">
                        <img src="https://cdn.bceres.com/upi-icon/GPay.png" class="w-100">
                    </div>
                    <div class="col-sm-2">
                        <img src="https://cdn.bceres.com/upi-icon/Paytm.png" class="w-100">
                    </div>
                    <div class="col-sm-2">
                        <img src="https://cdn.bceres.com/upi-icon/amazonpay.png" class="w-100">
                    </div>
                    <div class="col-sm-2">
                        <img src="https://cdn.bceres.com/upi-icon/PhonePay.png" class="w-100">
                    </div>
                    <div class="col-sm-2">
                        <img src="https://cdn.bceres.com/upi-icon//BHIM.png" class="w-100">
                    </div>
                    <div class="col-sm-2">
                        <img src="https://cdn.bceres.com/upi-icon/UPI.png" class="w-100">
                    </div>
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
            <div class="col-sm-12 col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">PAYMENT REQUEST</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="recharge_form">
                            <div class="form-group">
                                <label class="form-label" for="pwd">Bank Name:</label>
                                <select class="form-select mb-3 shadow-none">
                                    <option selected="">Select Bank Name</option>
                                    <option value="1">Bihar</option>
                                    <option value="2">Assam</option>
                                    <option value="3">Chandigarh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pwd">Payment Method:</label>
                                <select class="form-select mb-3 shadow-none">
                                    <option selected="">Select Payment Method</option>
                                    <option value="1">CASH DEPOSIT</option>
                                    <option value="2">NEFT / RTGS</option>
                                    <option value="3">IMPS</option>
                                    <option value="4">UPI / BARCODE</option>
                                    <option value="5">OTHERS</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pwd">Payment Date:</label>
                                <input type="date" class="form-control" id="pwd">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pwd">Amount:</label>
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="pwd">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="pwd">Bank Ref Number:</label>
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="pwd">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Now</button>
                            <button type="button" class="btn btn-secondary">Close</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7">
                <div class="card">
                    <div class="card-header ">
                        <div class="d-flex header-title justify-content-between">
                            <h5 class="card-title">BANK DETAILS</h5>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#detail_modal">View QR Code</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive resp">
                            <table id="datatable" class="table table-striped table_style" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>IFsc code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Auto Payment</td>
                                        <td>RAHUL SINGH RAJAWAT</td>
                                        <td>2223332659090228</td>
                                        <td>RATN0VAAPIS</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="conatiner-fluid content-inner py-0">
    <div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="d-flex header-title justify-content-between">
                            <h5 class="card-title">PAYMENT REQUEST</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive resp">
                            <table id="datatable" class="table table-striped table_style" data-toggle="data-table">
                                <thead>
                                    <tr role="row">
                                        <th>id</th>
                                        <th>Request Date</th>
                                        <th>Payment Date</th>
                                        <th>bank</th>
                                        <th>method</th>
                                        <th>amount</th>
                                        <th>UTR</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1344</td>
                                        <td>2022-10-19 00:13:03</td>
                                        <td>Auto Update Payment</td>
                                        <td>7000802198</td>
                                        <td>229245317561</td>
                                        <td>0.00</td>
                                        <td>1.00</td>
                                        <td>0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php') ?>