<script>
        // Modal Functions
        function openModal(type) {
            const modal = document.getElementById(`${type}Modal`);
            modal.classList.remove('hidden');
            modal.style.animation = 'modalEnter 0.3s ease-out';
        }

        function closeModal(type) {
            const modal = document.getElementById(`${type}Modal`);
            modal.style.animation = 'modalExit 0.3s ease-in';
            setTimeout(() => modal.classList.add('hidden'), 250);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                closeModal(event.target.id.replace('Modal', ''));
            }
        }
    </script>
</body>
</html>
<?php
// Include this at the end of every page if needed
?>