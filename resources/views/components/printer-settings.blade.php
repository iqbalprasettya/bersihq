<!-- Printer Settings Modal -->
<div id="printer-settings-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div
            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Pengaturan Printer
                    </h3>
                    <div class="mt-4">
                        <!-- QZ Tray Status -->
                        <div id="qz-status" class="mb-4 p-4 rounded-lg">
                            <p class="text-sm font-medium mb-2">Status QZ Tray:</p>
                            <div id="qz-status-indicator"
                                class="flex items-center justify-center p-2 rounded-lg bg-gray-100">
                                <svg class="animate-spin h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span class="text-sm">Memeriksa status QZ Tray...</span>
                            </div>
                        </div>

                        <!-- Printer Selection -->
                        <div id="printer-selection" class="hidden">
                            <label for="printer-select" class="block text-sm font-medium text-gray-700 text-left mb-2">
                                Pilih Printer
                            </label>
                            <select id="printer-select"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                                <option value="">Loading printers...</option>
                            </select>
                        </div>

                        <!-- Installation Instructions -->
                        <div id="installation-instructions" class="hidden text-left">
                            <p class="text-sm text-gray-500 mb-4">
                                QZ Tray belum terinstall atau tidak berjalan. Ikuti langkah-langkah berikut:
                            </p>
                            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600">
                                <li>Download QZ Tray dari <a href="https://qz.io/download/" target="_blank"
                                        class="text-green-600 hover:text-green-700">https://qz.io/download/</a></li>
                                <li>Install QZ Tray sesuai sistem operasi Anda</li>
                                <li>Biarkan QZ Tray jalan di background</li>
                            </ol>
                            <br>

                            <img src="{{ asset('img/qz.png') }}" alt="QZ Tray" class="w-1/2 mb-2">
                            <p class="text-xs text-gray-500 mt-2">
                                <strong>Keterangan:</strong> Gambar di atas adalah jendela notifikasi yang akan muncul saat aplikasi web meminta akses ke QZ Tray.<br>
                                <span class="text-green-700 font-semibold">Izinkan akses</span> pada gambar tersebut agar aplikasi dapat menggunakan printer.
                            </p>
                        </div>


                        <p class="mt-2 text-sm text-gray-500 text-left">
                            Pastikan QZ Tray sudah terinstall dan berjalan di komputer Anda.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" id="save-printer-settings"
                    class="hidden w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:col-start-2 sm:text-sm">
                    Simpan
                </button>
                <button type="button" id="close-printer-settings"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variable to track QZ connection state
    let qzConnected = false;

    // Update QZ Tray status indicator
    function updateQZStatus(isConnected) {
        qzConnected = isConnected;

        const statusIndicator = document.getElementById('qz-status-indicator');
        const printerSelection = document.getElementById('printer-selection');
        const installationInstructions = document.getElementById('installation-instructions');
        const saveButton = document.getElementById('save-printer-settings');

        if (isConnected) {
            statusIndicator.innerHTML = `
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm text-green-700">QZ Tray terhubung</span>
            `;
            statusIndicator.classList.remove('bg-gray-100', 'bg-red-50');
            statusIndicator.classList.add('bg-green-50');

            printerSelection.classList.remove('hidden');
            installationInstructions.classList.add('hidden');
            saveButton.classList.remove('hidden');

            // Populate printer list
            populatePrinters();
        } else {
            statusIndicator.innerHTML = `
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="text-sm text-red-700">QZ Tray tidak terhubung</span>
            `;
            statusIndicator.classList.remove('bg-gray-100', 'bg-green-50');
            statusIndicator.classList.add('bg-red-50');

            printerSelection.classList.add('hidden');
            installationInstructions.classList.remove('hidden');
            saveButton.classList.add('hidden');
        }
    }

    // Populate printer select dropdown
    async function populatePrinters() {
        try {
            if (typeof qz === 'undefined' || !qz.websocket.isActive()) {
                return;
            }

            const printers = await qz.printers.find();
            console.log("Available printers:", printers);

            // Populate printer select
            const printerSelect = document.getElementById('printer-select');
            if (printerSelect) {
                printerSelect.innerHTML = printers.map(printer =>
                    `<option value="${printer}">${printer}</option>`
                ).join('');

                // Set selected printer if exists in localStorage
                const savedPrinter = localStorage.getItem('selectedPrinter');
                if (savedPrinter && printers.includes(savedPrinter)) {
                    printerSelect.value = savedPrinter;
                } else if (printers.length > 0) {
                    // Try to find a thermal printer
                    const thermalPrinter = printers.find(p =>
                        p.toLowerCase().includes('58mm') ||
                        p.toLowerCase().includes('thermal') ||
                        p.toLowerCase().includes('receipt') ||
                        p.toLowerCase().includes('pos')
                    );

                    if (thermalPrinter) {
                        printerSelect.value = thermalPrinter;
                        localStorage.setItem('selectedPrinter', thermalPrinter);
                    }
                }
            }
        } catch (err) {
            console.error("Failed to get printers:", err);
        }
    }

    // Check QZ Tray connection status
    async function checkQZConnection() {
        try {
            if (typeof qz === 'undefined') {
                updateQZStatus(false);
                return;
            }

            if (await qz.websocket.isActive()) {
                updateQZStatus(true);
            } else {
                try {
                    await qz.websocket.connect();
                    updateQZStatus(true);
                } catch (err) {
                    console.error("Failed to connect to QZ Tray:", err);
                    updateQZStatus(false);
                }
            }
        } catch (err) {
            console.error("Error checking QZ connection:", err);
            updateQZStatus(false);
        }
    }

    // Save printer settings
    function savePrinterSettings() {
        const printerSelect = document.getElementById('printer-select');
        const selectedPrinter = printerSelect.value;

        if (selectedPrinter) {
            // Save printer name
            localStorage.setItem('selectedPrinter', selectedPrinter);

            // Save timestamp of last configuration
            localStorage.setItem('printerConfigTimestamp', new Date().toISOString());

            // Save connection status
            localStorage.setItem('qzConnected', qzConnected ? 'true' : 'false');

            printer = selectedPrinter;
            closePrinterSettings();

            // Show success notification
            const successAlert = document.createElement('div');
            successAlert.className =
                'fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-lg z-50';
            successAlert.innerHTML = `
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">Pengaturan printer berhasil disimpan!</p>
                    </div>
                </div>
            `;
            document.body.appendChild(successAlert);

            // Remove success message after 3 seconds
            setTimeout(() => {
                successAlert.remove();
            }, 3000);
        }
    }

    // Show printer settings modal
    function showPrinterSettings() {
        document.getElementById('printer-settings-modal').classList.remove('hidden');
        checkQZConnection();
    }

    // Close printer settings modal
    function closePrinterSettings() {
        document.getElementById('printer-settings-modal').classList.add('hidden');
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Set up save button click handler
        const saveButton = document.getElementById('save-printer-settings');
        if (saveButton) {
            saveButton.addEventListener('click', savePrinterSettings);
        }

        // Set up close button click handler
        const closeButton = document.getElementById('close-printer-settings');
        if (closeButton) {
            closeButton.addEventListener('click', closePrinterSettings);
        }
    });

    // Print function
    async function printToThermal(orderId, orderData) {
        try {
            // Check if this order was recently printed (within last 5 minutes)
            if (wasRecentlyPrinted(orderId)) {
                // Ask for confirmation before printing again
                if (!confirm('Invoice ini sudah dicetak dalam 5 menit terakhir. Cetak lagi?')) {
                    return; // User canceled the print
                }
            }

            // Check QZ Tray connection
            if (typeof qz === 'undefined') {
                alert('QZ Tray tidak terinstall. Silakan install QZ Tray terlebih dahulu.');
                showPrinterSettings();
                return;
            }

            // Check if connected to QZ Tray
            if (!await qz.websocket.isActive()) {
                try {
                    // Try to reconnect using saved connection status
                    const savedConnectionStatus = localStorage.getItem('qzConnected');
                    if (savedConnectionStatus === 'true') {
                        console.log('Attempting to reconnect to QZ Tray using saved connection status');
                    }

                    await qz.websocket.connect();
                } catch (err) {
                    alert('Tidak dapat terhubung ke QZ Tray. Pastikan QZ Tray sudah berjalan.');
                    showPrinterSettings();
                    return;
                }
            }

            // Get selected printer
            let selectedPrinter = localStorage.getItem('selectedPrinter');

            // If no printer selected, try to get available printers
            if (!selectedPrinter) {
                const printers = await qz.printers.find();

                // Try to find a thermal printer
                selectedPrinter = printers.find(p =>
                    p.toLowerCase().includes('58mm') ||
                    p.toLowerCase().includes('thermal') ||
                    p.toLowerCase().includes('receipt') ||
                    p.toLowerCase().includes('pos')
                );

                // If still no printer found, use first available
                if (!selectedPrinter && printers.length > 0) {
                    selectedPrinter = printers[0];
                }

                // If still no printer, show settings
                if (!selectedPrinter) {
                    alert('Tidak ada printer yang tersedia. Silakan pilih printer terlebih dahulu.');
                    showPrinterSettings();
                    return;
                }

                // Save selected printer
                localStorage.setItem('selectedPrinter', selectedPrinter);
            }

            // Show loading message
            const loadingMessage = document.createElement('div');
            loadingMessage.className =
                'fixed bottom-4 right-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-r shadow-lg z-50';
            loadingMessage.innerHTML = `
                <div class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Mencetak invoice...</span>
                </div>
            `;
            document.body.appendChild(loadingMessage);

            // If we don't have order data and orderId is provided, try to fetch it
            if (!orderData && orderId) {
                try {
                    const response = await fetch(`/orders/${orderId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.success && data.order) {
                        orderData = data.order;
                    }
                } catch (err) {
                    console.error('Error fetching order data:', err);
                    // Continue with basic info if fetch fails
                }
            }

            // If we have order data, use it
            let orderNumber = orderId;
            let customerName = '';
            let serviceName = '';
            let weight = '';
            let totalPrice = '';
            let pricePerKg = '';
            let orderDate = new Date().toLocaleDateString('id-ID');
            let status = '';
            let notes = '';

            if (orderData) {
                orderNumber = String(orderData.id).padStart(5, '0');
                customerName = orderData.customer ? orderData.customer.nama : '';
                serviceName = orderData.service ? orderData.service.nama_layanan : '';
                weight = orderData.berat ? orderData.berat + ' kg' : '';
                totalPrice = orderData.total_harga ? 'Rp ' + parseInt(orderData.total_harga).toLocaleString(
                    'id-ID') : '';

                // Get price per kg
                if (orderData.service && orderData.service.harga) {
                    pricePerKg = 'Rp ' + parseInt(orderData.service.harga).toLocaleString('id-ID') + '/kg';
                }

                if (orderData.created_at) {
                    try {
                        orderDate = new Date(orderData.created_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                    } catch (e) {
                        console.error('Error formatting date:', e);
                    }
                }

                status = orderData.status ?
                    orderData.status.charAt(0).toUpperCase() +
                    orderData.status.slice(1).replace('_', ' ') : '';

                notes = orderData.catatan || '';
            }

            // Create ESC/POS commands for 58mm thermal printer
            const data = [];

            // Initialize printer
            data.push('\x1B\x40'); // ESC @ - Initialize printer

            // Set line spacing to minimum
            data.push('\x1B\x33\x00'); // ESC 3 0 - Set line spacing to minimum

            // Set text alignment to center
            data.push('\x1B\x61\x01'); // ESC a 1 - Center alignment

            // Print header with larger font
            data.push('\x1B\x21\x30'); // ESC ! 0x30 - Double height and width
            data.push('BersihQ Laundry\n');
            data.push('\x1B\x21\x00'); // ESC ! 0x00 - Normal font
            data.push('Jl. Contoh No. 123\n');
            data.push('Telp: 0812-3456-7890\n');

            // Divider
            data.push('--------------------------------\n');

            // Set text alignment to left
            data.push('\x1B\x61\x00'); // ESC a 0 - Left alignment

            // Order details
            data.push(`No. Order  : #${orderNumber}\n`);
            data.push(`Tanggal    : ${orderDate}\n`);
            data.push(`Pelanggan  : ${customerName}\n`);

            // Divider
            data.push('--------------------------------\n');

            // Service details with bold
            data.push('\x1B\x45\x01'); // ESC E 1 - Bold on
            data.push(`${serviceName}\n`);
            data.push('\x1B\x45\x00'); // ESC E 0 - Bold off
            if (pricePerKg) {
                data.push(`${weight} x ${pricePerKg}\n`);
            } else {
                data.push(`${weight}\n`);
            }

            // Divider
            data.push('--------------------------------\n');

            // Total with bold
            data.push('\x1B\x45\x01'); // ESC E 1 - Bold on
            data.push(`TOTAL: ${totalPrice}\n`);
            data.push('\x1B\x45\x00'); // ESC E 0 - Bold off

            // Divider
            data.push('--------------------------------\n');

            // Footer
            // Status dan catatan tetap rata kiri
            data.push(`Status: ${status}\n`);
            if (notes) {
                data.push(`Catatan: ${notes}\n`);
            }

            // Tambahkan jarak sebelum ucapan terima kasih
            data.push('\n');

            // Center alignment untuk ucapan terima kasih
            data.push('\x1B\x61\x01'); // ESC a 1 - Center alignment
            data.push('Terima kasih\n');
            data.push('\x1B\x45\x01'); // ESC E 1 - Bold on
            data.push('BersihQ Laundry\n');
            data.push('\x1B\x45\x00'); // ESC E 0 - Bold off

            // Cut paper with minimal margin
            data.push('\x1D\x56\x42\x01'); // GS V B 1 - Cut paper with minimal feed

            // Configure printer
            const config = qz.configs.create(selectedPrinter, {
                encoding: "UTF-8",
                rasterize: false // Important: disable rasterization for ESC/POS commands
            });

            // Print
            await qz.print(config, data);

            // Remove loading message
            loadingMessage.remove();

            // Save this order to print history
            saveOrderToPrintHistory(orderId);

            // Show success message
            const successAlert = document.createElement('div');
            successAlert.className =
                'fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-lg z-50';
            successAlert.innerHTML = `
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">Berhasil mencetak invoice!</p>
                    </div>
                </div>
            `;
            document.body.appendChild(successAlert);

            // Remove success message after 3 seconds
            setTimeout(() => {
                successAlert.remove();
            }, 3000);

            console.log('Print job sent successfully');
        } catch (err) {
            console.error('Failed to print:', err);
            alert('Gagal mencetak: ' + err.message);

            // Try to get more detailed error info
            if (err.stack) {
                console.error('Error stack:', err.stack);
            }
        }
    }

    // Save printed order to localStorage history
    function saveOrderToPrintHistory(orderId) {
        try {
            // Get existing print history or initialize empty array
            const printHistoryString = localStorage.getItem('printHistory') || '[]';
            const printHistory = JSON.parse(printHistoryString);

            // Add current order to history with timestamp
            printHistory.push({
                orderId: orderId,
                timestamp: new Date().toISOString()
            });

            // Keep only the last 50 printed orders
            if (printHistory.length > 50) {
                printHistory.shift(); // Remove oldest entry
            }

            // Save back to localStorage
            localStorage.setItem('printHistory', JSON.stringify(printHistory));
        } catch (err) {
            console.error('Error saving print history:', err);
        }
    }

    // Check if order was recently printed (within last 5 minutes)
    function wasRecentlyPrinted(orderId) {
        try {
            const printHistoryString = localStorage.getItem('printHistory') || '[]';
            const printHistory = JSON.parse(printHistoryString);

            // Find the most recent print of this order
            const orderPrints = printHistory.filter(item => item.orderId == orderId);

            if (orderPrints.length === 0) {
                return false;
            }

            // Get the most recent print timestamp
            const latestPrint = orderPrints.reduce((latest, current) => {
                return new Date(current.timestamp) > new Date(latest.timestamp) ? current : latest;
            }, orderPrints[0]);

            // Check if it was printed within the last 5 minutes
            const fiveMinutesAgo = new Date(Date.now() - 5 * 60 * 1000);
            return new Date(latestPrint.timestamp) > fiveMinutesAgo;
        } catch (err) {
            console.error('Error checking print history:', err);
            return false;
        }
    }
</script>
