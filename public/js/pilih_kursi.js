document.addEventListener('DOMContentLoaded', function() {
    const seats = document.querySelectorAll('.seat:not(.booked)');
    const selectedSeatsDisplay = document.getElementById('selected-seats-display');
    const totalPriceDisplay = document.getElementById('total-price-display');
    const nomorKursiInput = document.getElementById('nomor_kursi_input');
    const btnSubmitBooking = document.getElementById('btn-submit-booking');
    const bookingForm = document.getElementById('booking-form');
    
    const ticketPrice = parseInt(bookingForm.getAttribute('data-ticket-price')) || 0;
    let selectedSeats = [];

    seats.forEach(seat => {
        seat.addEventListener('click', function() {
            const seatName = this.getAttribute('data-seat');
            
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s !== seatName);
            } else {
                this.classList.add('selected');
                selectedSeats.push(seatName);
            }
            
            updateUI();
        });
    });

    function updateUI() {
        // Update Selected Seats Badges
        if (selectedSeats.length === 0) {
            selectedSeatsDisplay.innerHTML = '<span style="color: var(--text-muted); font-size: 0.9rem; font-style: italic;">Belum ada kursi dipilih</span>';
            nomorKursiInput.value = '';
            btnSubmitBooking.disabled = true;
            totalPriceDisplay.textContent = 'Rp 0';
        } else {
            selectedSeatsDisplay.innerHTML = selectedSeats.map(s => `<span class="seat-badge">${s}</span>`).join('');
            nomorKursiInput.value = selectedSeats.join(',');
            btnSubmitBooking.disabled = false;
            
            // Format Total Price
            const total = selectedSeats.length * ticketPrice;
            totalPriceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }
});
