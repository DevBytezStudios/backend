<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import { cn } from '@/lib/utils';
import { useForm, usePage } from '@inertiajs/vue3';
import { EyeClosedIcon, EyeIcon } from 'lucide-vue-next';
import { ref, type HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();

import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
const showPassword = ref(false);
const info = ref({
    email: '',
    password: '',
});
const { error } = usePage().props;

const login = () => {
    if (info.value.email == '' || info.value.password == '') {
        toast.warning('Email ou senha vazios!');
        return;
    }

    const formData = useForm({
        email: info.value.email,
        password: info.value.password,
    });

    formData.post('/auth/login', {
        onError: ($error) => {
            console.log($error);
            toast.error('Email ou senha inválidos');
        },
    });
};

import { Toggle } from '@/components/ui/toggle';
</script>

<template>
    <div :class="cn('flex flex-col gap-6', props.class)">
        <Toaster position="bottom-center" />
        <Card>
            <CardHeader class="text-center">
                <CardTitle class="text-xl"> Login </CardTitle>
            </CardHeader>
            <CardContent>
                <form>
                    <FieldGroup>
                        <Field>
                            <FieldLabel for="email"> Email </FieldLabel>
                            <Input
                                id="email"
                                type="email"
                                placeholder="email@mail.com"
                                v-model="info.email"
                            />
                        </Field>
                        <Field>
                            <div class="flex items-center">
                                <FieldLabel for="password"> Senha </FieldLabel>
                                <a
                                    href="#"
                                    class="ml-auto text-sm underline-offset-4 hover:underline"
                                >
                                    Esqueceu a senha?
                                </a>
                            </div>

                            <InputGroup>
                                <InputGroupInput
                                    id="password"
                                    v-model="info.password"
                                    :type="
                                        showPassword == false
                                            ? 'password'
                                            : 'text'
                                    "
                                />
                                <InputGroupAddon align="inline-end">
                                    <Toggle
                                        aria-label="Toggle bold"
                                        class="h-8 w-8"
                                        v-model="showPassword"
                                    >
                                        <EyeIcon v-if="showPassword == false" />
                                        <EyeClosedIcon v-else />
                                    </Toggle>
                                </InputGroupAddon>
                            </InputGroup>
                        </Field>
                        <Field>
                            <Button type="button" @click="login">
                                Logar
                            </Button>
                        </Field>
                    </FieldGroup>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
