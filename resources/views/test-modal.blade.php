<!-- Modal Debug Test -->
<script>
// Add to any page for testing modal functionality
function testModal() {
    console.log('Testing modal...');
    console.log('Modal element:', document.getElementById('deleteModal'));
    console.log('Window deleteModal:', window.deleteModal);
    
    if (window.deleteModal) {
        console.log('Modal available, showing test modal...');
        window.deleteModal.show({
            title: 'Test Modal',
            message: 'This is a test of the delete modal system.',
            form: null
        });
    } else {
        console.log('Modal not available');
        alert('Modal not initialized yet');
    }
}

// Test after 2 seconds to ensure DOM is ready
setTimeout(testModal, 2000);
</script>