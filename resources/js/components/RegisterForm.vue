<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
} from '@/components/ui/card';
import { Field, FieldGroup, FieldLabel } from '@/components/ui/field';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import {
    Stepper,
    StepperItem,
    StepperSeparator,
    StepperTitle,
    StepperTrigger,
} from '@/components/ui/stepper';
import { Toggle } from '@/components/ui/toggle';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { Check, Circle, Dot, EyeClosedIcon, EyeIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import LoadingBar from './LoadingBar.vue';
import FieldDescription from './ui/field/FieldDescription.vue';
import FieldLegend from './ui/field/FieldLegend.vue';
import Input from './ui/input/Input.vue';

const currentStep = ref(1);
const steps = [
    {
        step: 1,
        title: 'Email e Senha',
    },
    {
        step: 2,
        title: 'Confeitaria',
    },
];

// FORMULARIO
const info = ref({
    email: '',
    password: '',
    confeitaria: {
        nome: '',
        cor_sec: '',
        cor: '',
    },
});
const showPassword = ref(false);

function nextStep() {
    console.log(info.value);
    // ETAPA INFORMAÇÔES
    if (currentStep.value == 1) {
        if (info.value.email == '' || info.value.password == '') {
            toast.warning('Email ou Senha inválidos!');
            return;
        }

        if (info.value.password.length < 8) {
            toast.warning('A senha precisa ter no minímo 8 carácteres!');
            return;
        }
    }

    if (currentStep.value < steps.length) {
        currentStep.value++;
    }
}

function prevStep() {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
}

const loading = ref(false);
const saveConfeitaria = async () => {
    if (
        info.value.confeitaria.nome == '' ||
        info.value.confeitaria.cor == '' ||
        info.value.confeitaria.cor_sec == ''
    ) {
        toast.warning('Verifique todas as infomações!');
        return;
    }

    try {
        loading.value = !loading.value;
        const formData = new FormData();
        const data = {
            confeitaria: info.value,
        };

        formData.append('data', JSON.stringify(data));

        const response = await axios.post('/auth/register', formData, {
            headers: { 'Content-Type': 'application/json' },
        });

        if (response.data.success) {
            toast.error(response.data.success.titulo);
            window.location.href = '/auth/login';
        } else {
            loading.value = !loading.value;
            toast.error(response.data.error.titulo);
        }
    } catch ($error) {
        console.log($error);
    }
};
</script>

<template>
    <Toaster position="bottom-center" />
    <LoadingBar :loading="loading" />
    <Stepper v-model="currentStep" class="flex w-full items-start gap-2">
        <StepperItem
            v-for="step in steps"
            :key="step.step"
            v-slot="{ state }"
            class="relative flex w-full flex-col items-center capitalize"
            :step="step.step"
            :linear="true"
        >
            <StepperSeparator
                v-if="step.step !== steps[steps.length - 1].step"
                class="absolute top-5 right-[calc(-50%+10px)] left-[calc(50%+20px)] h-0.5 rounded-full bg-muted group-data-[state=completed]:bg-primary"
            />

            <!-- Trigger DESABILITADO -->
            <StepperTrigger as-child>
                <Button
                    size="icon"
                    class="z-10 rounded-full"
                    :disabled="true"
                    :variant="
                        state === 'completed' || state === 'active'
                            ? 'default'
                            : 'outline'
                    "
                >
                    <Check v-if="state === 'completed'" class="size-5" />
                    <Circle v-else-if="state === 'active'" />
                    <Dot v-else />
                </Button>
            </StepperTrigger>

            <div class="mt-4 text-center">
                <StepperTitle
                    class="text-sm font-semibold"
                    :class="state === 'active' && 'text-primary'"
                >
                    {{ step.title }}
                </StepperTitle>
            </div>
        </StepperItem>
    </Stepper>

    <div class="mt-8">
        <!-- STEP 1 -->
        <div v-if="currentStep === 1" class="space-y-4">
            <Card>
                <CardHeader>
                    <!-- <CardTitle>Configurações da Conta</CardTitle> -->
                    <CardDescription>
                        Entre com as informações para configuração da conta
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="email"> Email </FieldLabel>
                                <Input
                                    id="email"
                                    type="email"
                                    placeholder="confeitaria@gmail.com"
                                    v-model="info.email"
                                    required
                                />
                            </Field>
                            <Field>
                                <div class="flex items-center">
                                    <FieldLabel for="password">
                                        Senha
                                    </FieldLabel>
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
                                            <EyeIcon
                                                v-if="showPassword == false"
                                            />
                                            <EyeClosedIcon v-else />
                                        </Toggle>
                                    </InputGroupAddon>
                                </InputGroup>
                                <FieldDescription class="text-center">
                                    Já tem uma conta?
                                    <Link href="/auth/login">
                                        Entrar
                                    </Link>
                                </FieldDescription>
                            </Field>
                        </FieldGroup>
                    </form>
                </CardContent>
            </Card>
            <Button class="w-full" @click="nextStep"> Proximo </Button>
        </div>

        <!-- STEP 2 -->
        <div v-if="currentStep === 2" class="space-y-4">
            <div class="flex flex-col gap-2">
                <Card>
                    <CardHeader>
                        <CardDescription>
                            As informações que irão aparecer para os seus
                            clientes
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form>
                            <FieldGroup>
                                <Field>
                                    <FieldLabel for="txtNome">
                                        Nome
                                    </FieldLabel>
                                    <Input
                                        id="txtNome"
                                        type="text"
                                        placeholder="Doce Sabor"
                                        v-model="info.confeitaria.nome"
                                        required
                                    />
                                </Field>
                                <Field>
                                    <FieldLegend
                                        >Cores da confeitaria</FieldLegend
                                    >
                                    <FieldDescription>
                                        Escolha as cores dos botões e demais
                                    </FieldDescription>
                                    <FieldLabel
                                        for="checkout-7j9-card-name-43j"
                                    >
                                        Cor principal
                                    </FieldLabel>
                                    <Input
                                        type="color"
                                        class="colorPicker"
                                        name="corPrincipal"
                                        v-model="info.confeitaria.cor"
                                    />
                                    <FieldLabel
                                        for="checkout-7j9-card-name-43j"
                                    >
                                        Cor segundaria
                                    </FieldLabel>
                                    <Input
                                        type="color"
                                        class="colorPicker"
                                        name="corSecundaria"
                                        v-model="info.confeitaria.cor_sec"
                                    />
                                </Field>
                            </FieldGroup>
                        </form>
                    </CardContent>
                </Card>

                <Button
                    class="w-full"
                    @click="saveConfeitaria"
                    :style="{ backgroundColor: info.confeitaria.cor }"
                >
                    <span class="mix-blend-normal">Proximo</span>
                </Button>

                <Button
                    variant="outline"
                    @click="prevStep"
                    class="w-full"
                    :style="{ backgroundColor: info.confeitaria.cor_sec }"
                >
                    <span class="">Voltar</span>
                </Button>
            </div>
        </div>
    </div>
</template>
