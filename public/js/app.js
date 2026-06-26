document.addEventListener('DOMContentLoaded', () => {
    const inventoryList = document.getElementById('inventoryList');
    const searchInput = document.getElementById('searchInput');
    const apiResponseCode = document.getElementById('apiResponse');

    // Modal Elements
    const adjustModal = document.getElementById('adjustModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('adjustmentForm');
    
    // Modal Inputs
    const batchIdInput = document.getElementById('batchIdInput');
    const reasonSelect = document.getElementById('reasonSelect');
    const newQuantityInput = document.getElementById('newQuantity');
    const noteInput = document.getElementById('noteInput');
    const submitBtn = document.getElementById('submitBtn');
    const diffIndicator = document.getElementById('diffIndicator');
    const statusMessage = document.getElementById('statusMessage');

    // Modal Display texts
    const modalBatchNum = document.getElementById('modalBatchNum');
    const modalProductName = document.getElementById('modalProductName');
    const modalWarehouse = document.getElementById('modalWarehouse');
    const modalCurrentStock = document.getElementById('modalCurrentStock');

    let allBatches = [];
    let currentEditingBatch = null;

    // Initialization
    fetchBatches();
    fetchReasons();

    // Search Filtering
    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        const filtered = allBatches.filter(b => 
            b.product_name.toLowerCase().includes(term) || 
            b.batch_number.toLowerCase().includes(term)
        );
        renderTable(filtered);
    });

    // Modal Handlers
    function openModal(batchId) {
        const batch = allBatches.find(b => b.id == batchId);
        if (!batch) return;
        currentEditingBatch = batch;

        // Populate Modal Info
        batchIdInput.value = batch.id;
        modalBatchNum.textContent = batch.batch_number;
        modalProductName.textContent = batch.product_name;
        modalWarehouse.textContent = batch.warehouse_name;
        modalCurrentStock.textContent = batch.quantity;
        
        // Reset inputs
        newQuantityInput.value = batch.quantity;
        reasonSelect.value = '';
        noteInput.value = '';
        updateDiff();
        hideMessage();

        adjustModal.classList.remove('hidden');
    }

    function close() {
        adjustModal.classList.add('hidden');
        currentEditingBatch = null;
    }

    closeModal.addEventListener('click', close);
    cancelBtn.addEventListener('click', close);
    adjustModal.addEventListener('click', (e) => {
        if(e.target === adjustModal) close();
    });

    newQuantityInput.addEventListener('input', updateDiff);

    function updateDiff() {
        const newQ = parseInt(newQuantityInput.value);
        if (isNaN(newQ) || !currentEditingBatch) {
            diffIndicator.textContent = 'Variance: --';
            diffIndicator.className = 'diff-indicator';
            return;
        }

        const diff = newQ - currentEditingBatch.quantity;
        diffIndicator.textContent = `Variance: ${diff > 0 ? '+' : ''}${diff}`;
        diffIndicator.className = `diff-indicator ${diff > 0 ? 'positive' : (diff < 0 ? 'negative' : '')}`;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const payload = {
            batch_id: parseInt(batchIdInput.value),
            reason_id: parseInt(reasonSelect.value),
            new_quantity: parseInt(newQuantityInput.value),
            note: noteInput.value
        };

        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        hideMessage();

        try {
            apiResponseCode.textContent = 'POST /api/inventory-adjustments\nWaiting for server...';
            const response = await fetch('/api/inventory-adjustments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            displayResponse(data, response.status);

            if (response.ok) {
                showMessage('Inventory adjusted successfully!', 'success');
                await fetchBatches(); // Refresh table
                setTimeout(() => {
                    if(!adjustModal.classList.contains('hidden')) close();
                }, 1500);
            } else {
                showMessage(data.message || 'An error occurred', 'error');
            }
        } catch (error) {
            showMessage(error.message, 'error');
            apiResponseCode.textContent = `Error: ${error.message}`;
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Confirm Adjustment';
        }
    });

    // API Helpers
    async function fetchBatches() {
        try {
            const res = await fetch('/api/batches');
            const data = await res.json();
            allBatches = data.data;
            renderTable(allBatches);
        } catch (e) {
            inventoryList.innerHTML = `<tr><td colspan="5" style="color:var(--danger)">Failed to load data.</td></tr>`;
        }
    }

    async function fetchReasons() {
        try {
            const res = await fetch('/api/reasons');
            const data = await res.json();
            
            reasonSelect.innerHTML = '<option value="">-- Select a reason --</option>';
            data.data.forEach(reason => {
                const opt = document.createElement('option');
                opt.value = reason.id;
                opt.textContent = reason.description;
                reasonSelect.appendChild(opt);
            });
        } catch (e) {
            console.error('Failed to load reasons');
        }
    }

    function renderTable(batches) {
        if (batches.length === 0) {
            inventoryList.innerHTML = '<tr><td colspan="5" style="text-align:center;">No batches found</td></tr>';
            return;
        }

        inventoryList.innerHTML = '';
        batches.forEach(batch => {
            const tr = document.createElement('tr');
            
            // We use global window.openModal to bind from string, or just attach event listener
            tr.innerHTML = `
                <td>
                    <div>${batch.product_name}</div>
                    <div class="badge-sku">SKU: WHL-00X</div> <!-- Mock SKU for demo view if not in response -->
                </td>
                <td><span style="color:var(--text-secondary)">${batch.warehouse_name}</span></td>
                <td><span style="font-family:monospace; color:var(--accent-color)">${batch.batch_number}</span></td>
                <td><span class="qty-badge">${batch.quantity}</span></td>
                <td>
                    <button class="btn-action" data-id="${batch.id}">Adjust</button>
                </td>
            `;
            inventoryList.appendChild(tr);
        });

        // Attach listeners to dynamically created buttons
        document.querySelectorAll('.btn-action').forEach(btn => {
            btn.addEventListener('click', (e) => {
                openModal(e.target.getAttribute('data-id'));
            });
        });
    }

    function showMessage(msg, type) {
        statusMessage.textContent = msg;
        statusMessage.className = `status-message ${type}`;
    }

    function hideMessage() {
        statusMessage.className = 'status-message hidden';
    }

    function displayResponse(data, status = 200) {
        const color = status >= 200 && status < 300 ? '#27c93f' : '#ff5f56';
        const statusText = `// HTTP Status: ${status}\n`;
        const jsonStr = JSON.stringify(data, null, 2);
        
        apiResponseCode.innerHTML = `<span style="color: ${color}">${statusText}</span>${syntaxHighlight(jsonStr)}`;
    }

    function syntaxHighlight(json) {
        if (!json) return '';
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            let cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) { cls = 'key'; } else { cls = 'string'; }
            } else if (/true|false/.test(match)) { cls = 'boolean';
            } else if (/null/.test(match)) { cls = 'null'; }
            
            let color = '#a5d6ff';
            if (cls === 'key') color = '#7ee787';
            if (cls === 'string') color = '#a5d6ff';
            if (cls === 'number') color = '#79c0ff';
            if (cls === 'boolean' || cls === 'null') color = '#ff7b72';
            
            return `<span style="color: ${color}">${match}</span>`;
        });
    }

    window.testEndpoint = async function(method, url) {
        apiResponseCode.textContent = `${method} ${url}\nFetching...`;
        try {
            const res = await fetch(url, { method });
            const data = await res.json();
            displayResponse(data, res.status);
        } catch (e) {
            apiResponseCode.textContent = `Error: ${e.message}`;
        }
    };
});

    window.testPostEndpoint = async function(url, payloadStr) {
        apiResponseCode.textContent = `POST ${url}\nSending payload...`;
        try {
            const payload = JSON.parse(payloadStr);
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            displayResponse(data, res.status);
            // Refresh table if success
            if (res.ok) {
                fetchBatches();
            }
        } catch (e) {
            apiResponseCode.textContent = `Error parsing JSON or network error:\n${e.message}`;
        }
    };
