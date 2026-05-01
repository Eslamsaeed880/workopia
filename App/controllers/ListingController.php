<?php

namespace App\controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Authorization;  

class ListingController {
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index() {
        $listings = $this->db->query("SELECT * FROM listings ORDER BY created_at DESC")->fetchAll();

        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    public function create() {
        loadView('listings/create');
    }

    public function show($params) {
        $id = $params['id'];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }

    /**
     * Store data in database
     *
     * @return void
     */
    public function store() {
        $allowedFields = [
            'title', 'description', 'salary', 
            'tags', 'requirements', 'benefits', 
            'company', 'address', 'city', 'state', 
            'phone', 'email', 'user_id'
        ];

        // Build new listing data from allowed POST fields, then attach the user id
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        // Attach currently-authenticated user id (placeholder until auth added)
        $newListingData['user_id'] = Session::get('user')['id'];

        // Sanitize all incoming values
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = [
            'title', 'description', 'email',
            'city', 'state'
        ];

        $errors = [];

        foreach($requiredFields as $field) {
            if(empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = "The " . ucfirst($field) . " field is required.";
            }
        }

        if(!empty($errors)) {
            // Reload view with errors and old data
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            // Submit data
            $fields = [];

            foreach($newListingData as $field => $value) {
                $fields[] = $field;
            }

            $fields = implode(', ', $fields);

            $values = [];

            foreach($newListingData as $field => $value) {
                // Convert empty strings to null
                if($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ":{$field}";
            }

            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

            $this->db->query($query, $newListingData);

            Session::setFlashMessage('success_message', 'Listing deleted successfully.');

            redirect('/listings');
        }
    }

    /**
     * Delete a listing
     *
     * @param array $params
     * @return void
     */
    public function destroy($params) {
        $id = $params['id'];
        
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        // Authorization check
        if(!Authorization::isOwner($listing['user_id'])) {
            Session::setFlashMessage('error_message', 'You are not authorized to delete this listing.');
            redirect('/listings/' . $id);
            return;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', ['id' => $id]);

        // Set a flash message for successful deletion (placeholder until flash messages added)
        Session::setFlashMessage('success_message', 'Listing deleted successfully.');

        redirect('/listings');
    }

    /**
     * Show the listing edit form
     * 
     * @param array $params
     * @return void
     */
    public function edit($params) {
        $id = $params['id'];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update a listing 
     * 
     * @param array $params
     * @return void
     */
    public function update($params) {
        $id = $params['id'];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        $allowedFields = [
            'title', 'description', 'salary', 
            'tags', 'requirements', 'benefits', 
            'company', 'address', 'city', 'state', 
            'phone', 'email', 'user_id'
        ];

        $upatedValues = [];

        $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updatedValues = array_map('sanitize', $updatedValues);

        $requiredFields = [
            'title', 'description', 'email',
            'city', 'state'
        ];

        $errors = [];

        foreach($requiredFields as $field) {
            if(empty($updatedValues[$field]) || !Validation::string($updatedValues[$field])) {
                $errors[$field] = "The " . ucfirst($field) . " field is required.";
            }
        }

        if(!empty($errors)) {
            // Reload view with errors and old data
            loadView('listings/edit', [
                'errors' => $errors,
                'listing' => $updatedValues
            ]);

            exit;
        } else {
            // Submit data
            $updateFields = [];

            foreach($updatedValues as $field => $value) {
                $updateFields[] = "{$field} = :{$field}";
            }

            $updateFields = implode(', ', $updateFields);

            $query = "UPDATE listings SET " . $updateFields . " WHERE id = :id";

            $this->db->query($query, array_merge($updatedValues, ['id' => $id]));

            Session::setFlashMessage('success_message', 'Listing updated successfully.');

            redirect('/listings/' . $id);
        }
    }
}