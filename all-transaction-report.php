<?php include('header.php') ?>
<!-- modal -->
<div class="modal fade" id="detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close border-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Report Id</label>
                                <input type="text" id="view_id" class="form-control" placeholder="Report ID" disabled="">
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Transaction Date</label>
                                <input type="text" id="view_created_at" class="form-control" placeholder="Date" disabled="">
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Provider</label>
                                <input type="text" id="view_provider" class="form-control" placeholder="Provider" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Number</label>
                                <input type="text" id="view_number" class="form-control" placeholder="Number" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Txnid</label>
                                <input type="text" id="view_txnid" class="form-control" placeholder="TXNID" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Opening Balance</label>
                                <input type="text" id="view_opening_balance" class="form-control" placeholder="Opening Balance" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Amount</label>
                                <input type="text" id="view_amount" class="form-control" placeholder="Amount" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Profit</label>
                                <input type="text" id="view_profit" class="form-control" placeholder="Profit" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Total Balance</label>
                                <input type="text" id="view_total_balance" class="form-control" placeholder="Total Balance" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Mode</label>
                                <input type="text" id="view_mode" class="form-control" placeholder="Mode" disabled="">
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Client Id</label>
                                <input type="text" id="view_client_id" class="form-control" placeholder="Client Id" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Ip Address</label>
                                <input type="text" id="view_ip_address" class="form-control" placeholder="Ip Address" disabled="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <input type="text" id="view_status_id" class="form-control" placeholder="Status" disabled="">
                            </div>
                        </div>



                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info">Receipt</button>
                <button type="button" class="btn btn-info">Mobile Receipt</button>
                <button type="button" class="btn btn-danger">Dispute</button>
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
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="rent_form rent_form_select2">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="pwd">From: *</label>
                                        <input type="date" class="form-control" id="pwd">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="pwd">To: *</label>
                                        <input type="date" class="form-control" id="pwd">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="pwd">Status: *</label>
                                        <select class="form-select mb-3 shadow-none">
                                            <option value="0" selected=""> All Status</option>
                                            <option value="1"> Success</option>
                                            <option value="2"> Failure</option>
                                            <option value="3"> Pending</option>
                                            <option value="4"> Refunded</option>
                                            <option value="5"> Refund Fail</option>
                                            <option value="6"> Credit</option>
                                            <option value="7"> Debit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-download" aria-hidden="true"></i>Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive resp">
                            <table id="datatable" class="table table-striped table_style" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date Time</th>
                                        <th>Provider</th>
                                        <th>Number</th>
                                        <th>Txnid</th>
                                        <th>Opening Balance</th>
                                        <th>Amount</th>
                                        <th>Profit</th>
                                        <th>Closing Balance</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <th>State</th>
                                        <th>Action</th>
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
                                        <td>1.00</td>
                                        <td>Normal</td>
                                        <td><span class="badge badge-primary">Credit</span></td>
                                        <td>All Zone</td>
                                        <td>
                                            <button class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#detail_modal"><i class="fa fa-eye"></i> View</button>
                                        </td>
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