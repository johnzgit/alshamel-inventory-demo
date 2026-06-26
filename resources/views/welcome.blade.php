<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alshamel WMS Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <div class="container">
        <header>
            <h1>Alshamel Medical</h1>
            <p>Warehouse Management System (WMS) - Inventory Control</p>
        </header>

        <main class="grid-layout">
            <!-- Left Side: Inventory List -->
            <section class="glass-panel inventory-section">
                <div class="panel-header" style="justify-content: space-between;">
                    <h2><span class="icon">📦</span> Current Inventory</h2>
                    <input type="text" id="searchInput" placeholder="Search SKU or Batch..." class="search-box">
                </div>
                
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Product / SKU</th>
                                <th>Warehouse</th>
                                <th>Batch</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryList">
                            <tr><td colspan="5" style="text-align: center;">Loading inventory data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Right Side: API Playground -->
            <section class="glass-panel api-playground">
                <div class="panel-header">
                    <h2><span class="icon">⚡</span> System Terminal (API Monitor)</h2>
                </div>
                
                <div class="api-docs" style="margin-bottom: 1rem;">
                    <!-- GET Batches -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method get">GET</span>
                            <span class="api-path">/api/batches</span>
                            <span class="api-desc">List all available batches</span>
                        </div>
                        <div class="api-body">
                            <button class="btn-secondary" onclick="testEndpoint('GET', '/api/batches')">Send Request</button>
                        </div>
                    </div>
                    
                    <!-- GET Reasons -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method get">GET</span>
                            <span class="api-path">/api/reasons</span>
                            <span class="api-desc">List adjustment reasons</span>
                        </div>
                        <div class="api-body">
                            <button class="btn-secondary" onclick="testEndpoint('GET', '/api/reasons')">Send Request</button>
                        </div>
                    </div>

                    <!-- GET History -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method get">GET</span>
                            <span class="api-path">/api/inventory-adjustments</span>
                            <span class="api-desc">View adjustment history</span>
                        </div>
                        <div class="api-body">
                            <button class="btn-secondary" onclick="testEndpoint('GET', '/api/inventory-adjustments')">Send Request</button>
                        </div>
                    </div>

                    <!-- POST Adjustment -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method post">POST</span>
                            <span class="api-path">/api/inventory-adjustments</span>
                            <span class="api-desc">Create new adjustment</span>
                        </div>
                        <div class="api-body">
                            <textarea id="mockPayload" class="payload-input">{
  "batch_id": 1,
  "reason_id": 1,
  "new_quantity": 95,
  "note": "Mock test from API docs"
}</textarea>
                            <button class="btn-secondary" onclick="testPostEndpoint('/api/inventory-adjustments', document.getElementById('mockPayload').value)">Send Request</button>
                        </div>
                    </div>
                </div>
                <div class="terminal">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span class="terminal-title">Network Response</span>
                    </div>
                    <pre><code id="apiResponse">// Real-time JSON payloads will appear here during adjustments...</code></pre>
                </div>
            </section>
        </main>
    </div>

    <!-- Adjustment Modal -->
    <div class="modal-backdrop hidden" id="adjustModal">
        <div class="glass-panel modal-content">
            <div class="modal-header">
                <h3>Adjust Batch: <span id="modalBatchNum" style="color: var(--accent-color);"></span></h3>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>
            
            <div class="product-info-card">
                <div class="info-row">
                    <span class="label">Product:</span>
                    <span class="value" id="modalProductName"></span>
                </div>
                <div class="info-row">
                    <span class="label">Location:</span>
                    <span class="value" id="modalWarehouse"></span>
                </div>
                <div class="info-row highlight">
                    <span class="label">System Qty:</span>
                    <span class="value" id="modalCurrentStock"></span>
                </div>
            </div>

            <form id="adjustmentForm" class="form-layout">
                <input type="hidden" id="batchIdInput">
                
                <div class="form-group">
                    <label for="reasonSelect">Reason for Adjustment</label>
                    <select id="reasonSelect" required>
                        <option value="">Loading reasons...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="newQuantity">Actual Counted Qty</label>
                    <input type="number" id="newQuantity" min="0" required placeholder="Enter the exact physical count">
                    <div class="diff-indicator" id="diffIndicator">Variance: --</div>
                </div>

                <div class="form-group">
                    <label for="noteInput">Inspector Notes (Optional)</label>
                    <textarea id="noteInput" rows="2" placeholder="Explain the discrepancy (e.g., 'Found 2 damaged items on shelf')"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-primary" id="submitBtn">Confirm Adjustment</button>
                </div>
                
                <div id="statusMessage" class="status-message hidden"></div>
            </form>
        </div>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
