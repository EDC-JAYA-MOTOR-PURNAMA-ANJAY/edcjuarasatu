<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-card p-8 mx-4 max-w-sm w-full">
        <div class="text-center">
            <!-- Success Icon -->
            <div class="w-16 h-16 bg-custom-green bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-custom-green text-2xl"></i>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-semibold text-dark-gray mb-2">Berhasil Dikirim !</h3>

            <!-- Message -->
            <p class="text-text-secondary mb-6">Data Berhasil Dikirim !</p>

            <!-- OK Button -->
            <button onclick="closeSuccessModal()"
                    class="w-full px-6 py-3 bg-primary-purple text-white rounded-lg hover:bg-purple-700 transition duration-200">
                Oke
            </button>
        </div>
    </div>
</div>

<script>
    function showSuccessModal() {
        document.getElementById('successModal').classList.remove('hidden');
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
    }

    // Auto show modal if there's success message
    @if(session('success'))
        showSuccessModal();
    @endif
</script>
