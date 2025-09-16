<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <!-- Modal Title -->
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4" id="deleteModalTitle">
                Confirm Deletion
            </h3>
            
            <!-- Modal Content -->
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="deleteModalMessage">
                    Are you sure you want to delete this item? This action cannot be undone.
                </p>
                
                <!-- Dependencies Warning -->
                <div id="dependenciesWarning" class="hidden mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Dependencies Found</h4>
                            <div class="mt-1 text-sm text-yellow-700" id="dependenciesList">
                                <!-- Dependencies will be populated here -->
                            </div>
                            <div class="mt-3" id="dependencyOptions">
                                <label class="flex items-center">
                                    <input type="radio" name="deleteAction" value="cascade" class="form-radio h-4 w-4 text-red-600" checked>
                                    <span class="ml-2 text-sm text-yellow-700">Delete all related items</span>
                                </label>
                                <label class="flex items-center mt-2">
                                    <input type="radio" name="deleteAction" value="reassign" class="form-radio h-4 w-4 text-red-600">
                                    <span class="ml-2 text-sm text-yellow-700">Reassign to another entity</span>
                                </label>
                            </div>
                            <div id="reassignOptions" class="hidden mt-3">
                                <label class="block text-sm font-medium text-yellow-800">Reassign to:</label>
                                <select id="reassignTarget" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Actions -->
            <div class="items-center px-4 py-3">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button id="confirmDeleteBtn" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                    <button id="cancelDeleteBtn" 
                            class="px-4 py-2 bg-gray-300 text-gray-900 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
class DeleteModal {
    constructor() {
        this.modal = document.getElementById('deleteModal');
        this.titleEl = document.getElementById('deleteModalTitle');
        this.messageEl = document.getElementById('deleteModalMessage');
        this.dependenciesWarning = document.getElementById('dependenciesWarning');
        this.dependenciesList = document.getElementById('dependenciesList');
        this.dependencyOptions = document.getElementById('dependencyOptions');
        this.reassignOptions = document.getElementById('reassignOptions');
        this.reassignTarget = document.getElementById('reassignTarget');
        this.confirmBtn = document.getElementById('confirmDeleteBtn');
        this.cancelBtn = document.getElementById('cancelDeleteBtn');
        
        this.currentForm = null;
        this.currentUrl = null;
        
        this.init();
    }
    
    init() {
        // Cancel button
        this.cancelBtn.addEventListener('click', () => this.hide());
        
        // Click outside to close
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.hide();
        });
        
        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                this.hide();
            }
        });
        
        // Dependency action radio buttons
        document.querySelectorAll('input[name="deleteAction"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.value === 'reassign') {
                    this.reassignOptions.classList.remove('hidden');
                } else {
                    this.reassignOptions.classList.add('hidden');
                }
            });
        });
        
        // Confirm delete
        this.confirmBtn.addEventListener('click', () => this.performDelete());
    }
    
    show(options = {}) {
        const {
            title = 'Confirm Deletion',
            message = 'Are you sure you want to delete this item? This action cannot be undone.',
            url = null,
            form = null,
            dependencies = null,
            reassignOptions = []
        } = options;
        
        this.titleEl.textContent = title;
        this.messageEl.textContent = message;
        this.currentUrl = url;
        this.currentForm = form;
        
        // Handle dependencies
        if (dependencies && dependencies.length > 0) {
            this.showDependencies(dependencies, reassignOptions);
        } else {
            this.dependenciesWarning.classList.add('hidden');
        }
        
        this.modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    hide() {
        this.modal.classList.add('hidden');
        document.body.style.overflow = '';
        this.reset();
    }
    
    reset() {
        this.currentForm = null;
        this.currentUrl = null;
        this.dependenciesWarning.classList.add('hidden');
        this.reassignOptions.classList.add('hidden');
        document.querySelector('input[name="deleteAction"][value="cascade"]').checked = true;
    }
    
    showDependencies(dependencies, reassignOptions = []) {
        let dependencyHtml = '<ul class="list-disc list-inside">';
        dependencies.forEach(dep => {
            dependencyHtml += `<li>${dep}</li>`;
        });
        dependencyHtml += '</ul>';
        
        this.dependenciesList.innerHTML = dependencyHtml;
        
        // Populate reassign options
        if (reassignOptions.length > 0) {
            let optionsHtml = '<option value="">Select...</option>';
            reassignOptions.forEach(option => {
                optionsHtml += `<option value="${option.id}">${option.name}</option>`;
            });
            this.reassignTarget.innerHTML = optionsHtml;
        } else {
            // Hide reassign option if no alternatives available
            this.dependencyOptions.querySelector('label:nth-child(2)').style.display = 'none';
        }
        
        this.dependenciesWarning.classList.remove('hidden');
    }
    
    performDelete() {
        if (this.currentForm) {
            // Add dependency action data if dependencies exist
            if (!this.dependenciesWarning.classList.contains('hidden')) {
                const deleteAction = document.querySelector('input[name="deleteAction"]:checked').value;
                this.addHiddenInput('delete_action', deleteAction);
                
                if (deleteAction === 'reassign' && this.reassignTarget.value) {
                    this.addHiddenInput('reassign_to', this.reassignTarget.value);
                }
            }
            
            this.currentForm.submit();
        } else if (this.currentUrl) {
            window.location.href = this.currentUrl;
        }
        
        this.hide();
    }
    
    addHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        this.currentForm.appendChild(input);
    }
}

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.deleteModal = new DeleteModal();
});

// Helper function to show delete confirmation
function confirmDelete(options) {
    window.deleteModal.show(options);
}
</script>