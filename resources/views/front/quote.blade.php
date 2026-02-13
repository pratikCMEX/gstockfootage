<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Request Quote</title>
</head>

<body>

    <div class="container">
        <h2>Tell us about yourself</h2>

        <form method="POST" action="{{ route('quote.store') }}">
            @csrf
            <div class="grid">

                <div>
                    <label>First name *</label>
                    <input type="text" name="first_name" required>
                </div>

                <div>
                    <label>Last name *</label>
                    <input type="text" name="last_name" required>
                </div>

                <div>
                    <label>Phone number *</label>
                    <input type="text" name="phone" required>
                </div>

                <div>
                    <label>Business Email Address *</label>
                    <input type="email" name="email" required>
                </div>

                <div>
                    <label>Company *</label>
                    <input type="text" name="company" required>
                </div>

                <div>
                    <label>Job Role *</label>
                    <select name="job_role" required>
                        <option value="">Select...</option>
                        <option>Producer</option>
                        <option>Director</option>
                        <option>Editor</option>
                        <option>Marketing</option>
                        <option>Executive</option>
                        <option>Other</option>
                    </select>
                </div>

                <div>
                    <label>Job Function *</label>
                    <select name="job_function" required>
                        <option value="">Select...</option>
                        <option>Creative</option>
                        <option>Marketing</option>
                        <option>Production</option>
                        <option>Business Development</option>
                        <option>Procurement</option>
                        <option>Other</option>
                    </select>
                </div>

                <div>
                    <label>Company Size *</label>
                    <select name="company_size" required>
                        <option value="">Select...</option>
                        <option>1-10</option>
                        <option>11-50</option>
                        <option>51-200</option>
                        <option>201-500</option>
                        <option>500+</option>
                    </select>
                </div>

                <div class="full">
                    <label>Country *</label>
                    <select name="country" required>
                        <option value="">Select...</option>
                        <option>United States</option>
                        <option>United Kingdom</option>
                        <option>Canada</option>
                        <option>Australia</option>
                        <option>Germany</option>
                        <option>France</option>
                        <option>India</option>
                    </select>
                </div>

                <div>
                    <label>State or province</label>
                    <input type="text" name="state">
                </div>

                <div>
                    <label>Product Of Interest *</label>
                    <select name="product_interest" required>
                        <option value="">Select...</option>
                        <option>Stock Footage</option>
                        <option>Stock Photos</option>
                        <option>Artwork</option>
                        <option>Raw Footage</option>
                        <option>Full Library Access</option>
                    </select>
                </div>

                <div class="full checkbox">
                    <input type="checkbox" name="newsletter" value="1">
                    <span>Keep me updated with newsletters, editorial highlights, events, and product updates.</span>
                </div>

                <div class="full">
                    <button type="submit">Request quote</button>
                </div>

            </div>
        </form>
    </div>

</body>

</html>
