// Universal delete function for all entities
function universalDelete(entityType, entityId, entityName, formSelector = null) {
    console.log(`universalDelete called: ${entityType} ${entityId} "${entityName}"`);
    
    // Find the form
    let form;
    if (formSelector) {
        form = document.querySelector(formSelector);
    } else {
        form = document.getElementById(`delete-${entityType}-${entityId}`);
    }
    
    if (!form) {
        console.error(`Form not found for ${entityType} ${entityId}`);
        alert(`Error: Could not find delete form for ${entityType}. Please refresh the page.`);
        return;
    }
    
    const message = `Are you sure you want to delete the ${entityType} "${entityName}"?`;
    
    // Try to use modal, fall back to confirm
    try {
        if (window.deleteModal && typeof window.deleteModal.show === 'function') {
            console.log('Using modal for', entityType);
            window.deleteModal.show({
                title: `Delete ${entityType.charAt(0).toUpperCase() + entityType.slice(1)}`,
                message: message,
                form: form
            });
        } else {
            throw new Error('Modal not available');
        }
    } catch (error) {
        console.log(`Fallback to browser confirm for ${entityType}:`, error);
        if (confirm(message)) {
            form.submit();
        }
    }
}

// Specific delete functions that use the universal one
function deleteOutcome(outcomeId, outcomeTitle) {
    universalDelete('outcome', outcomeId, outcomeTitle);
}

function deleteParticipant(participantId, participantName) {
    universalDelete('participant', participantId, participantName);
}

function removeParticipant(participantId, participantName) {
    universalDelete('participant', participantId, participantName, `#remove-participant-${participantId}`);
}

function deleteFacility(facilityId, facilityName) {
    universalDelete('facility', facilityId, facilityName);
}