import './bootstrap';

// Auto-hide flash messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Image Preview Function
window.previewImage = function(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('image-preview');
            
            if (preview && previewContainer) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
};

// Photo Preview Function
window.previewPhoto = function(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('photo-preview');
            
            if (preview && previewContainer) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
};

// Add Ingredient Function
window.addIngredient = function() {
    const container = document.getElementById('ingredients-container');
    const newInput = document.createElement('div');
    newInput.className = 'ingredient-item mb-3 flex gap-2';
    newInput.innerHTML = `
        <input type="text" 
                name="ingredients[]" 
                class="input flex-1"
                placeholder="Tambahkan bahan lainnya">
        <button type="button" 
                onclick="removeItem(this)" 
                class="btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newInput);
};

// Add Step Function
window.addStep = function() {
    const container = document.getElementById('steps-container');
    const stepCount = container.children.length + 1;
    const newStep = document.createElement('div');
    newStep.className = 'step-item mb-3 flex gap-2';
    newStep.innerHTML = `
        <textarea name="steps[]" 
                    rows="3"
                    class="input flex-1"
                    placeholder="Langkah ${stepCount}"></textarea>
        <button type="button" 
                onclick="removeItem(this)" 
                class="btn btn-danger self-start">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newStep);
};

// Remove Item Function
window.removeItem = function(button) {
    button.parentElement.remove();
};

// Smooth scroll to top
window.scrollToTop = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

// Mobile menu toggle
window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
};