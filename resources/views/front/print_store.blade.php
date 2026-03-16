<style>
    .print-store-section {
        background: #f5f5f5;
        padding: 40px 20px 80px;
        min-height: 70vh;
    }

    .container {
        max-width: 1200px;
        margin: auto;
    }

    /* top bar */

    .store-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .prints-count {
        color: #777;
        font-size: 14px;
    }

    .sort-box {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #666;
    }

    .sort-box select {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #ddd;
        background: #fff;
        font-size: 14px;
    }

    /* divider */

    .store-divider {
        height: 1px;
        background: #e2e2e2;
        margin-bottom: 60px;
    }

    /* center section */

    .coming-soon-wrapper {
        text-align: center;
        max-width: 520px;
        margin: auto;
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background: #eee;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        margin-bottom: 20px;
    }

    .coming-soon-wrapper h2 {
        font-size: 24px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .coming-soon-wrapper p {
        color: #777;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    /* buttons */

    .store-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn.primary {
        background: #ff7a00;
        color: #fff;
    }

    .btn.primary:hover {
        background: #e66e00;
    }

    .btn.outline {
        border: 1px solid #333;
        color: #333;
    }

    .btn.outline:hover {
        background: #333;
        color: #fff;
    }

    /* responsive */

    @media (max-width:768px) {

        .store-top-bar {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .store-divider {
            margin-bottom: 40px;
        }

        .coming-soon-wrapper h2 {
            font-size: 20px;
        }

    }
</style>

<section class="print-store-section">
    <div class="container">

        <div class="store-top-bar">
            <div class="prints-count">0 prints available</div>

            <div class="sort-box">
                <label>Sort by:</label>
                <select>
                    <option>Newest First</option>
                    <option>Oldest First</option>
                    <option>Popular</option>
                </select>
            </div>
        </div>

        <div class="store-divider"></div>

        <div class="coming-soon-wrapper">

            <div class="icon-box">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"
                        stroke="#999" stroke-width="1.5" />
                </svg>
            </div>

            <h2>Print Store Coming Soon</h2>

            <p>
                We're preparing our collection of museum-quality Giclée prints.
                Check back soon to discover premium archival prints for your home or office.
            </p>

            <div class="store-buttons">
                <a href="{{ route('all_photos') }}" class="btn primary">Browse Photography</a>
                <a href="javascript:void(0);" class="btn outline">Browse Artwork</a>
            </div>

        </div>

    </div>
</section>
