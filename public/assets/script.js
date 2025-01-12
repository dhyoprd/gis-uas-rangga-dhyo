//Current Location
document.getElementById("get-current-location").addEventListener("click", function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Use a reverse geocoding API to get the location name based on coordinates
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                .then(response => response.json())
                .then(data => {
                    const location = data.display_name;
                    document.getElementById("start-location").value = location;
                    document.getElementById("start-address").textContent = location;
                })
                .catch(error => {
                    console.error("Error fetching location: ", error);
                });
        }, function(error) {
            console.error("Error getting location: ", error);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

// Inisialisasi Maps
let leafletMap = L.map("leafletMap").setView(
    [-8.409518, 115.188919],  // Koordinat Bali
    9
);

let googleMap = new google.maps.Map(document.getElementById("googleMap"), {
    center: { lat: -8.409518, lng: 115.188919 },
    zoom: 9,
});

// Add Leaflet tile layer (OSM)
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
}).addTo(leafletMap);

// Routing controls
let leafletRoutingControl = null;
const directionsService = new google.maps.DirectionsService();
const directionsRenderer = new google.maps.DirectionsRenderer({
    map: googleMap,
});

// Variable lokasi
let startLocation = null;
let endLocation = null;
let startAddress = "";
let endAddress = "";

// Inisialisasi geocoder
const geocoder = new google.maps.Geocoder();

// Fungsi Mendapatkan Alamat dari Kordinat
async function getAddressFromCoordinates(lat, lng) {
    return new Promise((resolve, reject) => {
        geocoder.geocode({ location: { lat, lng } }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                    resolve(results[0].formatted_address);
                } else {
                    resolve(`${lat.toFixed(6)}, ${lng.toFixed(6)}`);
                }
            } else {
                resolve(`${lat.toFixed(6)}, ${lng.toFixed(6)}`);
            }
        });
    });
}

// Fungsi untuk Menampilkan Rute
async function calculateRoute(destination) {
    if (!startLocation) {
        alert("Please set a starting location first!");
        return;
    }

    endLocation = destination;
    endAddress = await getAddressFromCoordinates(destination.lat, destination.lng);

    // Clear existing routes
    if (leafletRoutingControl) {
        leafletMap.removeControl(leafletRoutingControl);
    }
    directionsRenderer.setMap(null);
    directionsRenderer.setMap(googleMap);

    // Calculate route for Leaflet
    leafletRoutingControl = L.Routing.control({
        waypoints: [
            L.latLng(startLocation.lat, startLocation.lng),
            L.latLng(destination.lat, destination.lng),
        ],
        routeWhileDragging: true,
        showAlternatives: true,
        fitSelectedRoutes: true,
        lineOptions: {
            styles: [{ color: "#0000ff", opacity: 0.6, weight: 6 }],
        },
    }).addTo(leafletMap);

    // Calculate route for Google Maps
    const request = {
        origin: startLocation,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING,
    };

    directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(result);
        } else {
            console.error("Error calculating route:", status);
        }
    });
}

// Tombol untuk Mendapatkan Lokasi Saat Ini
document
    .getElementById("get-current-location")
    .addEventListener("click", async () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    startLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    startAddress = await getAddressFromCoordinates(
                        startLocation.lat,
                        startLocation.lng
                    );
                    document.getElementById("start-location").value =
                        startAddress;

                    // Update peta
                    leafletMap.setView([startLocation.lat, startLocation.lng], 12);
                    googleMap.setCenter(startLocation);
                },
                (error) => {
                    console.error("Error getting location:", error);
                    alert(
                        "Unable to get your location. Please enter it manually."
                    );
                }
            );
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    });

// Tombol Set Lokasi Manual
document.getElementById("set-manual-location").addEventListener("click", () => {
    const locationInput = document.getElementById("start-location").value;
    if (locationInput) {
        geocoder.geocode(
            { address: locationInput },
            async (results, status) => {
                if (status === "OK" && results[0]) {
                    startLocation = {
                        lat: results[0].geometry.location.lat(),
                        lng: results[0].geometry.location.lng(),
                    };
                    startAddress = results[0].formatted_address;

                    leafletMap.setView(
                        [startLocation.lat, startLocation.lng],
                        12
                    );
                    googleMap.setCenter(startLocation);

                    updateRouteInfo();
                } else {
                    alert(
                        "Could not find the specified location. Please try again."
                    );
                }
            }
        );
    } else {
        alert("Please enter a starting location.");
    }
});

// Add marker untuk Leaflet dan Google Maps
fetch('/api/puras') // Ganti dengan API endpoint Anda
    .then(response => response.json())
    .then(data => {
        data.forEach(pura => {
            const markerLatLng = { lat: parseFloat(pura.latitude), lng: parseFloat(pura.longitude) };

            // Marker di Leaflet
            const leafletMarker = L.marker(markerLatLng)
                .addTo(leafletMap)
                .bindPopup(`
                    <div class="popup-content">
                        <strong>${pura.nama}</strong><br>
                        ${pura.alamat}<br>
                        Tahun Dibuat: ${pura.tahun_dibuat}<br>
                        <img src="${pura.foto}" alt="${pura.nama}" style="width:100px;height:auto;">
                        <br><br>
                       <button class="route-btn" onclick="calculateRoute({ lat: ${pura.latitude}, lng: ${pura.longitude} })">Direction</button>
                    </div>
                `);

            // Marker di Google Maps
            const googleMarker = new google.maps.Marker({
                position: markerLatLng,
                map: googleMap,
                title: pura.nama,
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div class="popup-content" style="color: black;">
                        <strong>${pura.nama}</strong><br>
                        ${pura.alamat}<br>
                        Tahun Dibuat: ${pura.tahun_dibuat}<br>
                        <img src="${pura.foto}" alt="${pura.nama}" style="width:100px;height:auto;">
                        <br><br>
                        <button class="route-btn" onclick="calculateRoute({ lat: ${pura.latitude}, lng: ${pura.longitude} })">Direction</button>

                    </div>
                `,
            });

            googleMarker.addListener("click", () => {
                infoWindow.open(googleMap, googleMarker);
            });
        });
    })
    .catch(error => console.error('Error loading pura data:', error));



// Update marker popup to include route button
function createMarkerPopup(pura) {
    return `
         <div class="popup-content">
            <strong>${pura.nama}</strong>
            <div class="address">${pura.alamat}</div>
            <div class="year">Tahun Dibuat: ${pura.tahun_dibuat}</div>
            <img src="${pura.foto}" alt="${pura.nama}" onerror="this.src='placeholder-image.jpg'">
            <button class="route-btn" onclick="calculateRoute(${pura.latitude}, ${pura.longitude})">
                Dapatkan Rute
            </button>
        </div>
    `;
}


function loadPuraData() {
    fetch('/api/puras')
        .then(response => response.json())
        .then(data => {
            data.forEach(pura => {
                addMarkers(pura);
            });
        })
        .catch(error => console.error('Error loading pura data:', error));
}

function addMarkers(pura) {
    const lat = parseFloat(pura.latitude);
    const lng = parseFloat(pura.longitude);

    if (isNaN(lat) || isNaN(lng)) return;

    // Add Leaflet marker
    const leafletMarker = L.marker([lat, lng]).addTo(leafletMap);
    leafletMarker.bindPopup(createMarkerPopup(pura));

    // Add Google Maps marker
    const googleMarker = new google.maps.Marker({
        position: { lat, lng },
        map: googleMap,
        title: pura.nama
    });

    const infoWindow = new google.maps.InfoWindow({
        content: createMarkerPopup(pura)
    });

    googleMarker.addListener('click', () => {
        infoWindow.open(googleMap, googleMarker);
    });
}

// Helper function to show notifications
function showNotification(message, type = 'info') {
    // Implement your preferred notification system here
    alert(message);
}


document.addEventListener('DOMContentLoaded', function() {
    initLeafletMap();
    initGoogleMap();  // Add this line
    initMobileMenu();
    initFormHandlers();
});

// Leaflet Map Initialization
function initLeafletMap() {
    // Bali coordinates
    const bali = [-8.409518, 115.188919];

    // Initialize Leaflet map
    const leafletMap = L.map('leafletMap').setView(bali, 9);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
    }).addTo(leafletMap);

    // Fetch data for markers
    fetch('/api/puras') // Replace with your Laravel API endpoint
        .then(response => response.json())
        .then(data => {
            data.forEach(pura => {
                // Add marker for each pura
                const marker = L.marker([pura.latitude, pura.longitude]).addTo(leafletMap);

                // Add popup with pura details
                marker.bindPopup(`
                     <div class="popup-content">
                            <strong>${pura.nama}</strong><br>
                            ${pura.alamat}<br>
                            Tahun Dibuat: ${pura.tahun_dibuat}<br>
                            <img src="${pura.foto}" alt="${pura.nama}" style="width:100px;height:auto;">
                            <br><br>
                            <button class="route-btn" onclick="getRoute(${pura.latitude}, ${pura.longitude})">Direction</button>
                        </div>
                `);
            });
        })
        .catch(error => console.error('Error loading pura data:', error));
}

// Google Maps Initialization
function initGoogleMap() {
    // Bali coordinates
    const bali = { lat: -8.409518, lng: 115.188919 };

    // Initialize Google map
    const googleMap = new google.maps.Map(document.getElementById('googleMap'), {
        zoom: 9,
        center: bali,
    });

    // Fetch data for markers
    fetch('/api/puras')
    .then(response => response.json())
    .then(data => {
        data.forEach(pura => {
            const lat = parseFloat(pura.latitude);
            const lng = parseFloat(pura.longitude);

            if (!isNaN(lat) && !isNaN(lng)) {
                const marker = new google.maps.Marker({
                    position: { lat, lng },
                    map: googleMap,
                    title: pura.nama,
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
            <div class="popup-content" style="color: black;">
            <strong>${pura.nama}</strong><br>
            ${pura.alamat}<br>
            Tahun Dibuat: ${pura.tahun_dibuat}<br>
            <img
                src="${pura.foto}"
                alt="${pura.nama}"
                style="width:100px;height:auto;">
            <br><br>
            <button
                class="route-btn"
                onclick="getRoute(${pura.latitude}, ${pura.longitude})">
                Direction
            </button>
        </div>
                    `,
                });

                marker.addListener('click', () => {
                    infoWindow.open(googleMap, marker);
                });
            } else {
                console.error(`Invalid lat/lng for pura: ${pura.nama}`, pura);
            }
        });
    })
    .catch(error => console.error('Error loading pura data:', error));

}

// Mobile Menu Handlers
function initMobileMenu() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton?.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden', !isHidden);
    });
}

// Modal Functions
function openModal(event) {
    event.preventDefault();
    const modal = document.getElementById('puraModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('puraModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Form Handlers
function initFormHandlers() {
    // File input handler
    const fileInput = document.getElementById('fotoPura');
    const fileLabel = document.getElementById('fileLabel');

    fileInput?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih File';
        if (fileLabel) {
            fileLabel.textContent = fileName;
        }
    });

    // Form submission handler
    const puraForm = document.getElementById('puraForm');
    puraForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        handleFormSubmit(this);
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('puraModal');
        if (event.target === modal) {
            closeModal();
        }
    };
}

// Form Submission Handler
async function handleFormSubmit(form) {
    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData,
            credentials: 'same-origin' // Include cookies
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const contentType = response.headers.get("content-type");
        if (contentType && contentType.indexOf("application/json") !== -1) {
            const result = await response.json();
            alert(result.message);
        } else {
            window.location.reload();
        }

        closeModal();
        form.reset();
    } catch (error) {
        console.error('Error submitting form:', error);
        alert('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }
}

// Map Switching Function
function showMap(mapType) {
    const leafletContainer = document.getElementById('leafletMap');
    const googleContainer = document.getElementById('googleMap');

    if (mapType === 'leaflet') {
        leafletContainer.classList.remove('hidden');
        googleContainer.classList.add('hidden');
        // Refresh Leaflet map size
        leafletMap?.invalidateSize();
    } else {
        leafletContainer.classList.add('hidden');
        googleContainer.classList.remove('hidden');
        // Refresh Google map
        google.maps.event.trigger(googleMap, 'resize');
    }
}

// Edit functions
function editPura(id) {
    fetch(`/pura/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_namaPura').value = data.nama;
            document.getElementById('edit_alamat').value = data.alamat;
            document.getElementById('edit_tahun').value = data.tahun_dibuat;
            document.getElementById('edit_latitude').value = data.latitude;
            document.getElementById('edit_longitude').value = data.longitude;

            const editForm = document.getElementById('editForm');
            editForm.action = `/pura/${id}`;

            // Show modal
            document.getElementById('editModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching pura data');
        });
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// File input handler for edit form
document.getElementById('edit_fotoPura')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Upload a file';
    document.getElementById('edit_fileLabel').textContent = fileName;
});

// Export functions that need to be accessed globally
window.openModal = openModal;
window.closeModal = closeModal;
window.showMap = showMap;
window.initGoogleMap = initGoogleMap;
