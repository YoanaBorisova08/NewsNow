
<form method="POST" action="create.php" enctype="multipart/form-data">
    <div class="form-group">
        <label class="form-group__label" for="title">Title:</label>
        <input
            class="form-group__input"
            type="text"
            id="title"
            name="title"
            required
            />
    </div>
    <div class="form-group">
        <label class="form-group__label" for="category">Category:</label>
        <select
            class="form-group__input"
            type="text"
            id="category"
            name="category"
            required
        >
        <option>sport</option>
        <option>politics</option>
        <option>celebrities</option>
        <option>health</option>
        <option>economy</option>
        </select>
    </div>
    <div class="form-group">
        <label class="form-group__label" for="short_text">Short text:</label>
        <textarea
            class="form-group__input"
            id="short_text"
            name="short_text"
            rows="3"
            required
        ></textarea>
    </div>
    <div class="form-group">
        <label class="form-group__label" for="full_text">Full text:</label>
        <textarea
            class="form-group__input"
            id="full_text"
            name="full_text"
            rows="6"
            required
        ></textarea>
    </div>
    <div class="form-group">
        <label class="form-group__label" for="image">Image:</label>
        <input
            class="form-group__input"
            type="file"
            id="image"
            name="image"
        />
    </div>
    <div class="form-submit">
        <button class="button">Save!</button>
    </div>
</form>