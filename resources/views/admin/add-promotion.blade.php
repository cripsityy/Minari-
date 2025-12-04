<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Add Promotion</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    </head>
    <body>
        <nav class="navbar-custom fixed-top">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center w-100 px-5">
                    <div class="logo">
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                    </div>
                    <div class="navbar-icons">
                        <img src="{{ asset('images/notification.png') }}" alt="Favorite" width="24" height="24"></a>
                        <img src="{{ asset('images/searchnav.png') }}" alt="Search" width="24" height="24"></a>
                        <img src="{{ asset('images/email.png') }}" alt="Cart" width="24" height="24"></a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
                <i class="fas fa-table-columns"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products') }}" class="sidebar-item">
                <i class="fas fa-box"></i>
                <span>Product</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-item">
                <i class="fas fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-item">
                <i class="fas fa-file-invoice"></i>
                <span>Orders</span>
            </a>
            <a href="{{ route('admin.customers') }}" class="sidebar-item">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('admin.reviews') }}" class="sidebar-item">
                <i class="fas fa-thumbs-up"></i>
                <span>Review</span>
            </a>
            <a href="{{ route('admin.promotions') }}" class="sidebar-item active">
                <i class="fas fa-ad"></i>
                <span>Promotions</span>
            </a>
        </div>
        
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Add New Promotion</h2>
                <a href="{{ route('admin.promotions') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Back to Promotions
                </a>
            </div>

            <div class="form-container">
                <form id="promotionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Promo Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="promoCode" placeholder="Enter promo code" required>
                                <div class="validation-message error" id="promoCodeError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="discountType" required>
                                    <option value="">Select discount type</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                                <div class="validation-message error" id="discountTypeError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="discountValue" placeholder="Enter discount value" min="0" required>
                                <div class="validation-message error" id="discountValueError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Minimum Purchase</label>
                                <input type="number" class="form-control" id="minPurchase" placeholder="Enter minimum purchase amount" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Enter promotion description" required></textarea>
                        <div class="validation-message error" id="descriptionError"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="startDate" required>
                                <div class="validation-message error" id="startDateError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="endDate" required>
                                <div class="validation-message error" id="endDateError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Usage Limit</label>
                                <input type="number" class="form-control" id="usageLimit" placeholder="Enter usage limit" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status">
                                    <option value="active">Active</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Applicable Products</label>
                        <select class="form-select" id="applicableProducts" multiple>
                            <option value="all">All Products</option>
                            <option value="category1">Summer Collection</option>
                            <option value="category2">Winter Collection</option>
                            <option value="category3">New Arrivals</option>
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('admin.promotions') }}'">
                            Cancel
                        </button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-plus"></i> Add Promotion
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="logo">
                            <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                        </div>
                        <p>Your everyday fashion boutique</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>Give us suggestions for future progress</p>
                        <div class="footer-form">
                            <input type="text" placeholder="your message . . .">
                            <button>Send</button>
                        </div>
                    </div>
                </div>
                <div class="footer-divider"></div>
                <div class="copyright">
                    © 2025 MINARI. All Rights Reserved.
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/addpromotionadmin.js') }}"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>
    </body>
</html>