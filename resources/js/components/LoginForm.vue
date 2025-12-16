<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldSeparator,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import { cn } from '@/lib/utils';
import { useForm, usePage } from '@inertiajs/vue3';
import { EyeIcon } from 'lucide-vue-next';
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
            console.log($error)
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
                            <Button variant="outline" type="button">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"
                                        fill="currentColor"
                                    />
                                </svg>
                                Entrar com o Google
                            </Button>
                        </Field>
                        <FieldSeparator
                            class="*:data-[slot=field-separator-content]:bg-card"
                        >
                            Ou
                        </FieldSeparator>
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
                                        <EyeIcon />
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
