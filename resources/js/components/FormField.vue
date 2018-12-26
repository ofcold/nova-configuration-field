<template>

    <div>
        <div class="h-9 bg-30 w-full"></div>

        <div v-for="itemField in field.configurations.fields" :ref="'config-'+field.configurations.value+'-fields'">
            <component
                :is="'form-' + itemField.component"
                :resource-id="resourceId"
                :resource-name="resourceName"
                :field="itemField"
                :ref="'field-' + itemField.attribute"
                :errors="errors"
            />
        </div>
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        fill(formData) {

            formData.append(this.field.attribute, this.value)

            this.$children.forEach(component => {

                if(component.field.attribute !== this.field.attribute) {
                    component.field.fill(formData);
                }
            })
        }
    },
}
</script>
