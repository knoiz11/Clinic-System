/*
 * appointmentemployeename.js
 * Provides a searchable employee dropdown for the appointment form.
 * - Uses AJAX-only search to query the server for matches
 * - Populates #employee_results and sets #employee_id on selection
 */

(function (window, document) {
    'use strict';

    function debounce(func, wait) {
        let timeout;
        return function () {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                func.apply(context, args);
            }, wait);
        };
    }

    function createItemHTMLElement(emp) {
        const div = document.createElement('div');
        div.className = 'employee-result-item p-2 d-flex justify-content-between align-items-center';
        div.dataset.id = emp.id;
        div.style.cursor = 'pointer';
        div.innerHTML = `<span>${emp.name}</span><small class="text-muted">${emp.designation || ''}</small>`;
        return div;
    }

    function initEmployeeSearch() {
        const input = document.getElementById('employee_search');
        const results = document.getElementById('employee_results');
        const hiddenId = document.getElementById('employee_id');
        let employees = [];
        let selectedIndex = -1;

        // For AJAX-only mode, we will fetch results from the server.

        function hideResults() {
            results.style.display = 'none';
            results.innerHTML = '';
        }

        function showResults(items) {
            results.innerHTML = '';
            selectedIndex = -1;
            if (!items || items.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'p-2 text-muted small';
                empty.textContent = 'No employees found.';
                results.appendChild(empty);
                results.style.display = 'block';
                return;
            }

            for (const emp of items) {
                const el = createItemHTMLElement(emp);
                el.addEventListener('click', () => {
                    input.value = emp.name;
                    hiddenId.value = emp.id;
                    hideResults();
                });
                results.appendChild(el);
            }
            results.style.display = 'block';
        }

        async function searchServer(query) {
            try {
                const url = `/admin/appointment/search/employees?query=${encodeURIComponent(query)}`;
                const resp = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });
                if (!resp.ok) return [];
                return await resp.json();
            } catch (err) {
                console.error('Server search failed', err);
                return [];
            }
        }

        const handleInput = debounce(async (e) => {
            const query = e.target.value.trim();
            hiddenId.value = ''; // reset selection when typing
            if (!query) {
                hideResults();
                return;
            }

            let items = await searchServer(query);
            // store the current results so we can match exact typed names later
            employees = items || [];

            showResults(items);
        }, 200);

        input.addEventListener('input', handleInput);

        // If the user clicks outside, hide the results
        document.addEventListener('click', (ev) => {
            if (!results.contains(ev.target) && ev.target !== input && !results.contains(ev.target)) {
                hideResults();
            }
        });

        // If blur and the input matches a name exactly, set the hidden id (we might still have employees in-memory after a search)
        input.addEventListener('blur', () => {
            // small delay so clicks can be handled first
            setTimeout(() => {
                if (!hiddenId.value) {
                    const match = employees.find(e => e.name === input.value) || null;
                    if (match) hiddenId.value = match.id;
                }
                hideResults();
            }, 200);
        });

        // Enable keyboard selection (arrow keys & enter)
        input.addEventListener('keydown', (ev) => {
            const items = results.querySelectorAll('.employee-result-item');
            if (!items.length) return;
            if (ev.key === 'ArrowDown') {
                ev.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                items.forEach((it, idx) => it.classList.toggle('bg-light', idx === selectedIndex));
            } else if (ev.key === 'ArrowUp') {
                ev.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                items.forEach((it, idx) => it.classList.toggle('bg-light', idx === selectedIndex));
            } else if (ev.key === 'Enter') {
                if (selectedIndex >= 0 && items[selectedIndex]) {
                    ev.preventDefault();
                    items[selectedIndex].click();
                }
            }
        });

        // On submit: ensure we have a selected employee id; if not, try to match exact name
        const appointmentForm = document.getElementById('addAppointmentForm');
        if (appointmentForm) {
            appointmentForm.addEventListener('submit', (ev) => {
                if (!hiddenId.value) {
                    const match = employees.find(e => e.name === input.value);
                    if (match) {
                        hiddenId.value = match.id;
                    } else {
                        // Not selected: prevent submission so the user can pick
                        ev.preventDefault();
                        alert('Please select an employee from the dropdown list before saving.');
                    }
                }
            });
        }
    }

    // expose globally
    window.initEmployeeSearch = initEmployeeSearch;

    // automatically init if DOM has the elements
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('employee_search')) {
            if (typeof window.initEmployeeSearch === 'function') {
                window.initEmployeeSearch();
            }
        }
    });

})(window, document);
